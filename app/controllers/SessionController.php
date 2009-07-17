<?php
namespace Gutshot\Controllers;

use Gutshot\Forms\LoginForm;
use Gutshot\Forms\SignUpForm;
use Gutshot\Forms\ForgotPasswordForm;
use Gutshot\Auth\Exception as AuthException;
use Gutshot\Models\Invitations;
use Gutshot\Models\Users;
use Gutshot\Models\ResetPasswords;

/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize()
    {
        if (is_array($this->auth->getIdentity())) {
            $this->view->setTemplateBefore('private');
            $this->response->redirect("index");
        }
        $this->view->setTemplateBefore('public');

    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $code = $this->dispatcher->getParam('code');
        $invitation = Invitations::findFirstByCode($code);
        if (!$invitation)
            $form = new SignUpForm();
        else
            $form = new SignUpForm(null, array(
                'inviter' => $invitation->usersId,
                'email' => $invitation->email,
            ));

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) != false) {

                $user = new Users();

                $post = array(
                    'player' => $this->request->getPost('player', 'striptags'),
                    'name' => $this->request->getPost('name', 'striptags'),
                    'location' => $this->request->getPost('location'),
                    'email' => $this->request->getPost('email'),
                    'inviterId' => $this->request->getPost('inviter'),
                    'password' => $this->security->hash($this->request->getPost('password')),
                    'groupsId' => 2,
                    'mustChangePassword' => 'N',
                    'active' => 'N',

                );
                $user->assign($post);

                if (!empty($post['inviterId'])) {
                    $invitation->update(
                        array(
                            'confirmed' => 'Yes'
                        )
                    );
                }

                $params = array("Command" => "AccountsAdd",
                    "Player" => $post['player'],
                    "RealName" => $post['name'],
                    "PW" => $post['password'],
                    "Location" => $post['location'],
                    "Email" => $post['email'],
                    "Chat" => "No",
                    "Note" => "Account created via API");

                if ($user->save()) {
                    $api = $this->getDI()->getApi()->poker($params);
                    if ($api->Result == "Ok") {
                        $this->dispatcher->forward(array(
                            'controller' => 'index',
                            'action' => 'index'
                        ));
                    } else {
                        $user->delete();
                        $this->flash->error($api->Error);
                    }
                }

                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {

            if (!$this->request->isPost()) {

                if ($this->auth->hasRememberMe()) {
                    $this->auth->loginWithRememberMe();
                }
            } else {

                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {

                    $this->auth->check(array(
                        'player' => $this->request->getPost('player'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember')
                    ));

                    $this->response->redirect('index');
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction()
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));
                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->id;
                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your inbox for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        $this->response->redirect('index');
    }
}
