<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class LoginForm extends Form
{

    public function initialize()
    {
        // Email
        $player = new Text('player', array(
            'placeholder' => 'Player'
        ));

        $player->addValidators(array(
            new PresenceOf(array(
                'message' => 'The username is required'
            )),
        ));

        $this->add($player);

        // Password
        $password = new Password('password', array(
            'placeholder' => 'Password'
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'The password is required'
        )));

        $password->clear();

        $this->add($password);

        // Remember
        $remember = new Check('remember', array(
            'value' => 'yes'
        ));

        $remember->setLabel('Remember me');

        $this->add($remember);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $csrf->clear();

        $this->add($csrf);

        $this->add(new Submit('go', array(
            'class' => 'btn btn-primary',
            'value' => 'Sign in'
        )));
    }
}
