<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Models\Cashouts;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use \Phalcon\Http\Response as Response;
use Gutshot\Forms\CashoutsForm;
use Gutshot\Models\Users;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class CashoutsController extends ControllerBase
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
        $this->view->form = new CashoutsForm();
    }

    /**
     * list all data
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $paidAtFrom = empty($this->request->getPost('paidAtFrom')) ? '1' : $this->request->getPost('paidAtFrom');
            $paidAtTo = empty($this->request->getPost('paidAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('paidAtTo');
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            if (empty($this->request->getPost('paidAtFrom')) and empty($this->request->getPost('paidAtTo')))
                $query = Criteria::fromInput($this->di, 'Gutshot\Models\Cashouts', $this->request->getPost())
                    ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            else
                $query = Criteria::fromInput($this->di, 'Gutshot\Models\Cashouts', $this->request->getPost())
                    ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))
                    ->betweenWhere('paidAt', strtotime($paidAtFrom), strtotime($paidAtTo))
                    ->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $cashouts = Cashouts::find($parameters);

        $paginator = new Paginator(array(
            "data" => $cashouts,
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
        $form = new CashoutsForm();
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $parameters = array(
                    "conditions" => "usersId =" . $this->auth->getId() . " AND status = 'No'",
                );
                $pendingCashouts = Cashouts::find($parameters);
                if (count($pendingCashouts) == 0) {
                    $cashout = new Cashouts();
                    $usersId = $this->auth->getId();
                    $cashoutPlayer = $this->auth->getPlayer();
                    $user = Users::findFirstById($usersId);
                    $amount = $this->request->getPost('amount');
                    $card = $user->card;
                    $account = $user->account;
                    $holder = $user->holder;
                    $bank = $user->bank;
                    $shaba = $user->shaba;

                    $cashout->assign(array(
                        'amount' => $amount,
                        'card' => $card,
                        'account' => $account,
                        'holder' => $holder,
                        'bank' => $bank,
                        'shaba' => $shaba,
                        'usersId' => $usersId,
                        'status' => 'No',
                    ));
                    if ($cashout->save()) {
                        $params = array("Command" => "AccountsGet",
                            "Player" => $cashoutPlayer,
                        );
                        $api = $this->getDI()->getApi()->poker($params);
                        if ($api->Result == "Ok") {
                            if ($api->Balance >= $amount) {
                                $params = array("Command" => "AccountsDecBalance",
                                    "Player" => $cashoutPlayer,
                                    "Amount" => $amount,
                                    "Negative" => 'Skip'
                                );
                                $api = $this->getDI()->getApi()->poker($params);
                                if ($api->Result == "Ok") {
                                    $this->flashSession->success("Transaction was done successfully");
                                } else {
                                    $cashout->delete();
                                    $this->flashSession->error("Transaction was not done successfully");
                                }
                            } else {
                                $this->flashSession->error("There is not enough credit to cashout");
                                $cashout->delete();
                            }

                        } else {
                            $cashout->delete();
                            $this->flashSession->error("Transaction was not created successfully");
                        }
                    } else {
                        foreach ($cashout->getMessages() as $error) {
                            $this->flashSession->error($error);
                        }
                    }
                } else {
                    $this->flashSession->error("First cancel your pending cashout.");
                }
                $this->response->redirect('cashouts');
            }
        }

        $parameters = array(
            "conditions" => 'usersId =' . $this->auth->getId(),
        );

        $cashouts = Cashouts::find($parameters);

        $this->view->page = $cashouts;
        $this->view->form = $form;
    }

    /**
     * Deletes a Cashout
     *
     * @param int $id
     */
    public function cancelAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $cashout = Cashouts::findFirstById($id);
            if (!$cashout || $cashout->usersId != $this->auth->getId()) {
                $this->flashSession->error("Cash out was not found");
            } elseif ($cashout->status == 'Yes') {
                $this->flashSession->error("Cash out has been paid");
            } else {
                if (!$cashout->update(
                    array(
                        'status' => 'Cancel',
                    )
                )
                ) {
                    foreach ($cashout->getMessages() as $error) {
                        $this->flashSession->error($error);
                    }
                } else {
                    $params = array("Command" => "AccountsIncBalance",
                        "Player" => $this->auth->getPlayer(),
                        "Amount" => $cashout->amount,
                    );
                    $api = $this->getDI()->getApi()->poker($params);

                    if ($api->Result == "Ok") {
                        $this->flashSession->success("Cash out was canceled");
                    } else {
                        $this->flashSession->error($api->Error);
                    }
                }
            }
        }
        $this->response->redirect('cashouts/index');
    }

    /**
     * Pay a Cash out
     *
     * @param int $id
     */
    public function payAction($id)
    {
        $cashout = Cashouts::findFirstById($id);
        if (!$cashout) {
            $this->flash->error("Cash out was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        } elseif ($cashout->status == 'Yes') {
            $this->flashSession->error("Cash out has been paid");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        } else {
            $cashout->status = 'Yes';
            $cashout->paidAt = time();
            if (!$cashout->save()) {
                foreach ($cashout->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flash->success("Cash out was paid");
            }

            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
    }

    /**
     * @param $id
     *
     * Cancel the request
     */
    public function rejectAction($id)
    {
        $cashout = Cashouts::findFirstById($id);
        if (!$cashout) {
            $this->flash->error("Cash out was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "AccountsIncBalance",
            "Player" => $cashout->user->player,
            "Amount" => $cashout->amount,
        );
        if (!$cashout->update(
            array(
                'status' => 'Reject',
            )
        )
        ) {
            foreach ($cashout->getMessages() as $error) {
                $this->flash->error($error);
            }
        } else {
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                $this->flash->success("Cash out was canceled");
            } else {
                $this->flash->error($api->Error);
            }
        }
        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }
}
