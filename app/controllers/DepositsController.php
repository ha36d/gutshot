<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\DepositsForm;
use Gutshot\Models\Deposits;
use Gutshot\Models\Users;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class DepositsController extends ControllerBase
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
        $this->view->form = new DepositsForm();
    }

    /**
     * list all deposits
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Deposits', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $deposits = Deposits::find($parameters);

        $paginator = new Paginator(array(
            "data" => $deposits,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Default action, shows the list and new form
     */
    public function indexAction()
    {
        $form = new DepositsForm();
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $deposit = new Deposits();

                $price = $this->request->getPost('amount');

                $deposit->assign(array(
                    'amount' => $price,
                    'usersId' => $this->auth->getId(),
                    'status' => 'No',
                ));
                if (!$deposit->save()) {
                    foreach ($deposit->getMessages() as $error) {
                        $this->flashSession->error($error);
                    }
                } else {

                    $url = $this->config->pardakht_api['pardakht_url'];
                    $api_id = $this->config->pardakht_api['pardakht_id'];
                    $back_url = $this->config->pardakht_api['back_url'];
                    $id = $deposit->id;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "id=$api_id&resnum=$id&amount=$price&callback=$back_url");
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    if ($result > 0 && is_numeric($result)) {
                        $go = "http://pardakhtnet.com/webservice/go.php?id=$result";
                        $this->dispatcher->forward($go);
                        //error messages
                    } else {
                        $message = 'Error in Deposit';
                        switch (intval($result)) {
                            case -1:
                                $message .= 'MerchantID is incorrect.';
                                break;
                            case -2:
                                $message .= 'The amount is not valid';
                                break;
                            case -3:
                                $message .= 'The callback address is not correct';
                                break;
                            case -4:
                                $message .= 'Shetab Gateway is not working';
                                break;
                            case -5:
                                $message .= 'resnum is not valid';
                                break;
                            case -6:
                                $message .= 'MerchanID is duplicate';
                                break;
                            case -7:
                                $message .= 'Error in connecting to bank';
                                break;
                        }
                        $deposit->delete();
                        $this->flashSession->error($message . "Transaction was not created successfully");
                    }
                }
                $this->response->redirect('deposits');
            }
        }

        $parameters = array(
            "conditions" => 'usersId =' . $this->auth->getId(),
        );

        $deposits = Deposits::find($parameters);

        $this->view->form = $form;
        $this->view->page = $deposits;
    }

    /**
     * back function from payment website
     */
    public function backAction()
    {

        if ($this->request->isPost()) {

            if (!$res_num = $this->request->getPost('resnum')) {
                $this->view->notice('Error in Transaction. No Order ID is available.');
            }
            if (!$ref_num = $this->request->getPost('refnum')) {
                $this->view->notice('Error in Transaction. No Transaction ID is available.');
            } else {
                $deposits = Deposits::find(array("conditions" => 'ref =' . $ref_num));
                if (count($deposits) > 0) {
                    $this->view->notice("Error in Transaction. Duplicate deposit.");
                } else {
                    $deposit = Deposits::findFirst(array("conditions" => 'id =' . $res_num));

                    if (count($deposit) == 0) {
                        $this->view->notice("Error in Transaction. The order does not exist.");
                    } else {
                        $url = $this->config->pardakht_api['pardakht_url'];
                        $api_id = $this->config->pardakht_api['pardakht_id'];
                        $fields = array(
                            'resnum' => urlencode($res_num),
                            'refnum' => urlencode($ref_num),
                            'id' => urlencode($api_id),
                            'amount' => urlencode($deposit->amount)
                        );
                        $fields_string = "";
                        foreach ($fields as $key => $value) {
                            $fields_string .= $key . '=' . $value . '&';
                        }
                        rtrim($fields_string, '&');

                        $ch = curl_init($url);

                        //set the url, number of POST vars, POST data
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, count($fields));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        //execute post
                        $result = curl_exec($ch);
                        curl_close($ch);

                        $res = intval($result);

                        if ($res <= 0) {
                            $this->view->notice('Error in Transaction. The patment is not verified.');
                        } elseif ($res == '1') {
                            $deposit->update(
                                array(
                                    'status' => 'Yes',
                                    'ref' => $ref_num,
                                )
                            );
                            $this->view->notice('Transaction Succeeded. Order ID: ' . $res_num . ' - Refrence Number: ' . $ref_num . ' - Price: ' . $deposit->amount . ' - Thanks.');
                        }
                    }
                }
            }
        }
    }

    /**
     * increase or decrease balance
     */
    public function ChangeAction()
    {

        $form = new DepositsForm();
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $deposit = new Deposits();

                $amount = $this->request->getPost('amount');
                $usersId = $this->request->getPost('usersId');
                $change = $this->request->getPost('change');
                $comment = $this->request->getPost('comment');
                $operator = $this->auth->getPlayer();
                $player = Users::findFirstById($usersId)->player;

                $deposit->assign(array(
                    'amount' => $amount * $change,
                    'usersId' => $usersId,
                    'status' => 'Yes',
                    'type' => 'Handy',
                    'comment' => $comment,
                    'operator' => $operator,
                ));
                if (!$deposit->save()) {
                    foreach ($deposit->getMessages() as $error) {
                        $this->flashSession->error($error);
                    }
                } else {
                    if ($change == 1)
                        $params = array("Command" => "AccountsIncBalance",
                            "Player" => $player,
                            "Amount" => $amount,
                        );
                    elseif ($change == -1)
                        $params = array("Command" => "AccountsDecBalance",
                            "Player" => $player,
                            "Amount" => $amount,
                            "Negative" => "Skip",
                        );
                    $api = $this->getDI()->getApi()->poker($params);
                    if ($api->Result == "Ok") {
                        $this->flashSession->success("Deposit was done successfully");
                    } else {
                        $deposit->delete();
                        $this->flashSession->error("Deposit was not created successfully. " . $api->Error);
                    }
                    $this->response->redirect('deposits/change');
                }

            }
        }
        $this->view->form = $form;
    }

}
