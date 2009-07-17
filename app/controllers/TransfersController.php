<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Models\Users;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\TransfersForm;
use Gutshot\Models\Transfers;
use Gutshot\Api\Api;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class TransfersController extends ControllerBase
{

    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * search action, shows the search form
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new TransfersForm();
    }

    /**
     * list all data
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Transfers', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $transfers = Transfers::find($parameters);

        $paginator = new Paginator(array(
            "data" => $transfers,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $form = new TransfersForm();
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $fromId = $this->auth->getId();
                $user = Users::findFirstById($fromId);
                if ($user->pin == $this->request->getPost('code', 'striptags')) {

                    $transfer = new Transfers();

                    $amount = $this->request->getPost('amount', 'int');
                    $toPlayer = $this->request->getPost('usersId');
                    if ($to = Users::findFirstByPlayer($toPlayer)) {
                        $toId = $to->id;
                        if ($toId != $fromId) {
                            $fromPlayer = $this->auth->getPlayer();
                            $transfer->assign(array(
                                'amount' => $amount,
                                'fromId' => $fromId,
                                'toId' => $toId,
                            ));
                            if ($transfer->save()) {
                                $params = array("Command" => "AccountsGet",
                                    "Player" => $fromPlayer,
                                );
                                $api = $this->getDI()->getApi()->poker($params);
                                if ($api->Result == "Ok") {
                                    if ($api->Balance >= $amount) {
                                        $params = array("Command" => "AccountsDecBalance",
                                            "Player" => $fromPlayer,
                                            "Amount" => $amount,
                                            "Negative" => 'Zero'
                                        );
                                        $api = $this->getDI()->getApi()->poker($params);
                                        if ($api->Result == "Ok") {
                                            $params = array("Command" => "AccountsIncBalance",
                                                "Player" => $toPlayer,
                                                "Amount" => $amount,
                                            );
                                            $api = $this->getDI()->getApi()->poker($params);
                                            if ($api->Result == "Ok") {
                                                $this->flashSession->success("Transfer was done successfully");
                                            } else {
                                                $params = array("Command" => "AccountsIncBalance",
                                                    "Player" => $fromPlayer,
                                                    "Amount" => $amount,
                                                );
                                                $api = $this->getDI()->getApi()->poker($params);
                                                $transfer->delete();
                                                $this->flashSession->error("Transfer was not done successfully");
                                            }
                                        } else {
                                            $transfer->delete();
                                            $this->flashSession->error("Transfer was not done successfully");
                                        }
                                    } else {
                                        $this->flashSession->error("There is not enough credit to transfer");
                                        $transfer->delete();
                                    }
                                    foreach ($transfer->getMessages() as $error) {
                                        $this->flashSession->error($error);
                                    }
                                } else {
                                    $transfer->delete();
                                    $this->flashSession->error("Transaction was not created successfully");
                                }
                            } else {
                                $this->flashSession->error("Transaction was not created successfully");
                            }
                        } else {
                            $this->flashSession->error("User can't transfer to itselt");
                        }
                    } else {
                        $this->flashSession->error("User does not exist");
                    }
                } else {
                    $this->flashSession->error("Pin Code error");
                }
                $this->response->redirect('transfers');
            }
        }

        $parameters = array(
            "conditions" => "fromId =" . $this->auth->getId() . " OR toId =" . $this->auth->getId(),
        );

        $transfers = Transfers::find($parameters);

        $this->view->form = $form;
        $this->view->page = $transfers;

    }

}
