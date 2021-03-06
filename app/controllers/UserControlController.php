<?php
namespace Gutshot\Controllers;

use Gutshot\Models\EmailConfirmations;
use Gutshot\Models\ResetPasswords;

/**
 * UserControlController
 * Provides help to users to confirm their passwords or reset them
 */
class UserControlController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    /**
     * Confirms an e-mail, if the user must change thier password then changes it
     */
    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');

        $confirmation = EmailConfirmations::findFirstByCode($code);

        if (!$confirmation) {
            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

        if ($confirmation->confirmed != 'N') {
            $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'login'
            ));
        }

        $confirmation->confirmed = 'Y';

        $confirmation->user->active = 'Y';

        /**
         * Change the confirmation to 'confirmed' and update the user to 'active'
         */
        if (!$confirmation->save()) {

            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

        /**
         * Identify the user in the application
         */
         $this->auth->authUserById($confirmation->user->id);

        /**
         * Check if the user must change his/her password
         */
        if ($confirmation->user->mustChangePassword == 'Y') {

            $this->flash->success('The email was successfully confirmed. Now you must change your password');

            $this->dispatcher->forward(array(
                'controller' => 'users',
                'action' => 'changePassword'
            ));
        }

        $this->flash->success('The email was successfully confirmed');

        $this->dispatcher->forward(array(
            'controller' => 'index',
            'action' => 'index'
        ));
    }

    public function resetPasswordAction()
    {
        $code = $this->dispatcher->getParam('code');

        $resetPassword = ResetPasswords::findFirstByCode($code);

        if (!$resetPassword) {
            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

        if ($resetPassword->reset != 'N') {
            $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'login'
            ));
        }

        $resetPassword->reset = 'Y';

        /**
         * Change the confirmation to 'reset'
         */
        if (!$resetPassword->save()) {

            foreach ($resetPassword->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

        /**
         * Identify the user in the application
         */
        $this->auth->authUserById($resetPassword->usersId);

        $this->flash->success('Please reset your password');

        $this->dispatcher->forward(array(
            'controller' => 'users',
            'action' => 'changePassword'
        ));
    }
}
