<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Models\Support;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\SupportForm;
use Gutshot\Forms\NewsForm;
use Gutshot\Models\Users;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class SupportController extends ControllerBase
{

    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Admin Chat tickets
     */
    public function listAction()
    {
        if (empty($numberPage = $this->request->getQuery("page", "int"))) {
            $numberPage = 1;
        }

        $parameters = array(
            "conditions" => "usersId != 0",
            "group" => "usersId",
            "order" => "createdAt DESC",
        );
        $supports = Support::find($parameters);
        if (count($supports) == 0) {
            $this->flash->notice("The box is empty.");
        }

        $paginator = new Paginator(array(
            "data" => $supports,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function newAction()
    {
        if (empty($numberPage = $this->request->getQuery("page", "int"))) {
            $numberPage = 1;
        }

        $parameters = array(
            "conditions" => "usersId != 0 AND type = 'request' AND toStatus = 'unread'",
            "order" => "createdAt DESC",
        );
        $supports = Support::find($parameters);
        if (count($supports) == 0) {
            $this->flash->notice("The box is empty.");
        }

        $paginator = new Paginator(array(
            "data" => $supports,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * User chat box
     */
    public function supportAction()
    {
        $form = new SupportForm();
        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $support) {
                    $this->flash->error($support);
                }
            } else {
                $support = new Support();
                $support->assign(array(
                    'content' => $this->request->getPost('content'),
                    'usersId' => $this->auth->getId(),
                    'fromStatus' => 'read',
                    'toStatus' => 'unread',
                ));

                if (!$support->save()) {
                    foreach ($support->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $this->flashSession->success("Ticket was sent successfully");
                }
                $this->response->redirect('support/support');
            }
        }

        $parameters = array(
            "conditions" => "usersId = " . $this->auth->getId() . " AND fromStatus != 'deleted'",
            "order" => "createdAt DESC",
        );
        $supports = Support::find($parameters);

        if (count($supports) != 0) {
            foreach ($supports as $supp) {
                if ($supp->type == 'respond')
                    $supp->update(
                        array(
                            "toStatus" => "read",
                        )
                    );
            }
        }
        $this->view->setVar('page', $supports);
        $this->view->form = $form;
    }

    /**
     * Message from admin
     */
    public function composeAction()
    {
        $form = new SupportForm();
        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $support) {
                    $this->flash->error($support);
                }
            } else {
                $support = new Support();
                $usersId = $this->request->getPost('usersId');
                $support->assign(array(
                    'content' => $this->request->getPost('content'),
                    'usersId' => $usersId,
                    'type' => 'respond',
                    'fromStatus' => 'read',
                    'toStatus' => 'unread',
                ));

                if (!$support->save()) {
                    foreach ($support->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $this->flash->success("Message was sent successfully");
                }
                $this->dispatcher->forward(array(
                    "action" => "list"
                ));
            }
        }

        $this->view->form = $form;
    }

    /**
     * @param $id
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * Admin Chat box
     */
    public function conversationAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            return $this->response->redirect('support/list');
        }
        $form = new SupportForm();
        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $support) {
                    $this->flash->error($support);
                }
            } else {
                $support = new Support();
                $support->assign(array(
                    'content' => $this->request->getPost('content'),
                    'type' => 'respond',
                    'usersId' => $user->id,
                    'fromStatus' => 'read',
                    'toStatus' => 'unread',
                ));

                if (!$support->save()) {
                    foreach ($support->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $this->flashSession->success("answer was sent successfully");
                }
                $this->response->redirect('support/conversation');
            }
        }

        $parameters = array(
            "conditions" => "usersId = " . $user->id,
            "order" => "createdAt DESC",
        );
        $supports = Support::find($parameters);

        if (count($supports) != 0) {
            foreach ($supports as $supp) {
                if ($supp->type == 'request')
                    $supp->update(
                        array(
                            "toStatus" => "read",
                        )
                    );
            }
        }

        $this->view->setVar('page', $supports);
        $this->view->form = $form;
    }

    /**
     * Clear support data
     */
    public function clearAction()
    {
        $this->view->disable();
        $parameters = array(
            "conditions" => "usersId = " . $this->auth->getId(),
        );
        $supports = Support::find($parameters);
        if (count($supports) != 0) {
            foreach ($supports as $support) {
                $support->update(
                    array(
                        "fromStatus" => "deleted",
                    )
                );
            }
            $this->flashSession->success("Chat History cleared");
        }
        $this->response->redirect('support/support');
    }
}

