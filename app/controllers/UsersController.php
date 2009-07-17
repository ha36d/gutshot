<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\ChangePasswordForm;
use Gutshot\Forms\UsersForm;
use Gutshot\Forms\InviteForm;
use Gutshot\Models\BalanceHistories;
use Gutshot\Models\HandHistories;
use Gutshot\Models\Users;
use Gutshot\Models\PasswordChanges;
use Gutshot\Models\Invitations;

/**
 * Gutshot\Controllers\UsersController
 * CRUD to manage users
 */
class UsersController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new UsersForm();
    }

    /**
     * Searches for users
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array();
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Users', $this->request->getPost());
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $users = Users::find($parameters);

        $paginator = new Paginator(array(
            "data" => $users,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a User
     */
    public function createAction()
    {
        if ($this->request->isPost()) {

            $user = new Users();

            $post = array(
                'player' => $this->request->getPost('player', 'striptags'),
                'name' => $this->request->getPost('name', 'striptags'),
                'location' => $this->request->getPost('location'),
                'email' => $this->request->getPost('email'),
                'password' => $this->security->hash($this->request->getPost('password')),
                'gender' => $this->request->getPost('gender'),
                'groupsId' => $this->request->getPost('groupsId', 'int'),
                'title' => $this->request->getPost('title'),
                'card' => $this->request->getPost('card'),
                'account' => $this->request->getPost('account'),
                'holder' => $this->request->getPost('holder'),
                'bank' => $this->request->getPost('bank'),
                'shaba' => $this->request->getPost('shaba'),
                'mustChangePassword' => 'N',
                'active' => 'Y',
            );

            $user->assign($post);

            $params = array("Command" => "AccountsAdd",
                "Player" => $post['player'],
                "RealName" => $post['name'],
                "PW" => $post['password'],
                "Location" => $post['location'],
                "Email" => $post['email'],
                "Chat" => "No",
                "Note" => "Account created via API");

            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $api = $this->getDI()->getApi()->poker($params);
                if ($api->Result == "Ok") {
                    $this->flashSession->success("User was created successfully");
                    $this->response->redirect('users/list');
                } else {
                    $user->delete();
                    $this->flashSession->error($api->Error);
                }
            }
        }

        $this->view->form = new UsersForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User was not found");
            $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }

        if ($this->request->isPost()) {

            $post = array(
                'player' => $this->request->getPost('player', 'striptags'),
                'name' => $this->request->getPost('name', 'striptags'),
                'location' => $this->request->getPost('location'),
                'email' => $this->request->getPost('email'),
                'groupsId' => $this->request->getPost('groupsId', 'int'),
                'gender' => $this->request->getPost('gender'),
                'title' => $this->request->getPost('title'),
                'card' => $this->request->getPost('card'),
                'account' => $this->request->getPost('account'),
                'holder' => $this->request->getPost('holder'),
                'bank' => $this->request->getPost('bank'),
                'shaba' => $this->request->getPost('shaba'),
                'banned' => $this->request->getPost('banned'),
                'suspended' => $this->request->getPost('suspended'),
                'active' => $this->request->getPost('active')
            );

            $user->assign($post);

            $params = array("Command" => "AccountsEdit",
                "Player" => $post['player'],
                "RealName" => $post['name'],
                "Location" => $post['location'],
                "Email" => $post['email'],
                "Chat" => "9999-99-99 99:99",
                "Level" => $post['level'],
                "Title" => $post['title'],
                "Gender" => $post['gender'],
                "Note" => "Account edited via API");
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                if (!$user->save()) {
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {
                    $this->flashSession->success("User was updated successfully");
                    $this->response->redirect('users/list');
                }
            } else {
                $this->flashSession->error($api->Error);
            }
        }

        $this->view->userDetails = $user;

        $this->view->form = new UsersForm($user, array(
            'edit' => true
        ));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User was not found");
            $this->dispatcher->forward(array(
                'action' => 'index'
            ));
        }
        $player = $user->player;
        if (!$user->delete()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
        } else {
            $params = array("Command" => "AccountsDelete",
                "Player" => $player,
            );
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                $this->flash->success("User was deleted");
            } else {
                $this->flash->error($api->Error);
            }
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Users must use this action to change its password
     */
    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = $this->auth->getUser();

                $password = $user->password = $this->security->hash($this->request->getPost('password'));
                $user->mustChangePassword = 'N';

                $passwordChange = new PasswordChanges();
                $passwordChange->user = $user;
                $passwordChange->ipAddress = $this->request->getClientAddress();
                $passwordChange->userAgent = $this->request->getUserAgent();

                if (!$passwordChange->save()) {
                    foreach ($passwordChange->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $params = array("Command" => "AccountsEdit",
                        "Player" => $user->player,
                        "PW" => $password,
                    );
                    $api = $this->getDI()->getApi()->poker($params);
                    if ($api->Result == "Ok") {
                        $this->flashSession->success('Your password was successfully changed');
                        $this->response->redirect('users/changePassword');
                    } else {
                        $this->flashSession->error($api->Error);
                    }

                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function profileAction()
    {
        if ($player = $this->request->getQuery("Player", "striptags")) {
            $profile = Users::findFirstByPlayer($player);
            if (!$profile) {
                $this->flash->error("User was not found");
            }
            $this->view->profile = $profile;
            $best_hand_win = HandHistories::find(
                array(
                    "columns" => "player, hand",
                    "conditions" => "type = 'Yes' AND hand_value > 0 AND player = '" . $player . "'",
                    "order" => "hand_value DESC",
                    "limit" => 5
                )
            );
            $this->view->setVars(
                array('best_hand_win' => $best_hand_win,
                    'publicUrl' => $this->config->application->publicUrl,
                ));
        }
        $data_source = array();
        $users = Users::find(array('conditions' => 'active = "Y"', 'columns' => 'player'));
        foreach ($users as $user) {
            $data_source[] = $user->player;
        }
        $this->view->Users = json_encode($data_source);
    }

    public function accountAction()
    {
        $user = $this->auth->getUser();
        if (!$user) {
            $this->flash->error("User was not found");
            $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'logout',
            ));
        }

        if ($this->request->isPost()) {
            if ($user->pin == $this->request->getPost('code', 'striptags')) {
                $post = array(
                    'name' => $this->request->getPost('name', 'striptags'),
                    'location' => $this->request->getPost('location'),
                    "gender" => $this->request->getPost('gender'),
                    "avatar" => $this->request->getPost('Avatar'),
                    "card" => $this->request->getPost('card'),
                    "account" => $this->request->getPost('account'),
                    "holder" => $this->request->getPost('holder'),
                    "bank" => $this->request->getPost('bank'),
                    'shaba' => $this->request->getPost('shaba'),
                );
                $user->assign($post);
                $params = array("Command" => "AccountsEdit",
                    "Player" => $this->auth->getPlayer(),
                    "RealName" => $post['name'],
                    "Location" => $post['location'],
                    "Gender" => $post['gender'],
                    "Avatar" => $post['avatar'],
                    "Note" => "Account edited via API");
                $api = $this->getDI()->getApi()->poker($params);
                if ($api->Result == "Ok") {
                    if (!$user->save()) {
                        foreach ($user->getMessages() as $message) {
                            $this->flashSession->error($message);
                        }
                    } else {
                        $this->flashSession->success("User was updated successfully");
                        $this->response->redirect('users/account');
                    }
                } else {
                    $this->flashSession->error($api->Error);
                }
            } else {
                $this->flashSession->error("Pin Code error");
            }
        }
        $parameters = array(
            "conditions" => "player = '" . $user->player . "'",
        );
        $balancesDetails = BalanceHistories::find($parameters);
        $this->view->balancesDetails = $balancesDetails;
        $params = array("Command" => "AccountsGet",
            "Player" => $user->player,
        );
        $api = $this->getDI()->getApi()->poker($params);
        $this->view->balance = $api->Balance;
        $this->view->userDetails = $user;
        $this->view->form = new UsersForm($user, array(
            'edit' => true
        ));
    }

    public function pinResendAction()
    {
        $pin = mt_rand(1000, 9999);
        $usersId = $this->auth->getId();
        $user = Users::findFirstById($usersId);
        $this->getDI()
            ->getMail()
            ->send(array(
                $user->email => $user->name
            ), "Pin Number", 'pin', array(
                'pin' => $pin,
            ));
        $user->update(
            array(
               'pin' =>  $pin,
            ));
        $this->flashSession->success('A confirmation mail has been sent to ' . $this->email);
        $this->response->redirect("users/account");
    }
}
