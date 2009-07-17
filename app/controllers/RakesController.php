<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Forms\RakesForm;
use Gutshot\Forms\InviteForm;
use Gutshot\Models\Users;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Models\Rakes;
use Gutshot\Models\Invitations;
use Phalcon\Mvc\Model\Query;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class RakesController extends ControllerBase
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
        $this->view->form = new RakesForm();
    }


    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Rakes', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $supports = Rakes::find($parameters);
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
     * Default action, Creates a new Rake
     */

    public function indexAction()
    {
        $form = new InviteForm();
        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = $this->auth->getId();

                $invitation = new Invitations();
                $invitation->usersId = $user;
                $invitation->email = $this->request->getPost('email');

                if (!$invitation->save()) {
                    foreach ($invitation->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {
                    $this->flashSession->success('Your invitation has been sent.');
                    $this->response->redirect('rakes');
                }
            }
        }
        $rakes = $this->modelsManager->createBuilder()
            ->columns(array('Rakes.id', 'Rakes.fromId', 'Rakes.amount', 'user.player', 'user.email', 'SUM(Rakes.amount) AS amounts'))
            ->from(array('Rakes' => 'Gutshot\Models\Rakes'))
            ->where("toId = '" . $this->auth->getId() . "' AND status = 'No'")
            ->leftJoin('Gutshot\Models\Users', 'Rakes.fromId = user.id', 'user')
            ->groupBy('Rakes.fromId')
            ->getQuery()
            ->execute();

        $rakes_accepted = $this->modelsManager->createBuilder()
            ->columns(array('Rakes.id', 'Rakes.fromId', 'Rakes.amount', 'user.player', 'user.email', 'SUM(Rakes.amount) AS total'))
            ->from(array('Rakes' => 'Gutshot\Models\Rakes'))
            ->where("toId = '" . $this->auth->getId() . "' AND status = 'Yes'")
            ->leftJoin('Gutshot\Models\Users', 'Rakes.fromId = user.id', 'user')
            ->groupBy('Rakes.fromId')
            ->getQuery()
            ->execute();

        $parameters = array(
            "conditions" => 'usersId =' . $this->auth->getId(),
        );

        $invitations = Invitations::find($parameters);

        $this->view->invitations = $invitations;
        $this->view->rakes = $rakes;
        $this->view->rakes_accepted = $rakes_accepted;
        $this->view->form = $form;
    }


    /**
     * Accept Rakes
     *
     * @param int $id
     */
    public function doneAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $amount = Rakes::sum(
                array(
                    "column" => "amount",
                    "conditions" => "toId = '" . $this->auth->getId() . "' AND fromId = '" . $id . "' AND status = 'No'",
                )
            );
            $parameters = array(
                "conditions" => "toId = '" . $this->auth->getId() . "' AND fromId = '" . $id . "' AND status = 'No'",
            );
            $rakes = Rakes::find($parameters);
            if (!$rakes) {
                $this->flashSession->error("Rake was not found");
            } else {
                foreach ($rakes as $rake) {
                    $rakes->update(
                        array(
                            'status' => 'Yes',
                        )
                    );
                }
                $params = array("Command" => "AccountsIncBalance",
                    "Player" => $this->auth->getPlayer(),
                    "Amount" => $amount,
                );
                $api = $this->getDI()->getApi()->poker($params);
                if ($api->Result == "Ok") {
                    $this->flashSession->success($amount . " chips added to balance successfully");
                } else {
                    $this->flashSession->error("Nothing was not added to account.");
                }
            }
        }
        $this->response->redirect('rakes/index');
    }

}