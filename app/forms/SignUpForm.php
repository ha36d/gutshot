<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class SignUpForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        if (isset($options['inviter'])) {
            $inviter = new Hidden('inviter',
                array(
                    'value' => $options['inviter'],
                ));
            $this->add($inviter);
        } else {
            $inviter = new Hidden('inviter',
                array(
                    'value' => '',
                ));
            $this->add($inviter);
        }

        //Player
        $player = new Text('player');

        $player->setLabel('Player');

        $player->addValidators(array(
            new PresenceOf(array(
                'message' => 'The player name is required'
            ))
        ));

        $this->add($player);

        // Name
        $name = new Text('name');

        $name->setLabel('Real Name');

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The real name is required'
            ))
        ));

        $this->add($name);

        if (isset($options['email'])) {
            // Email
            $email = new Text('email',
                array(
                    'value' => $options['email'],
                    'readonly' => true
                ));
        }
        else {
            $email = new Text('email');
        }

            $email->setLabel('E-Mail');

            $email->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The e-mail is required'
                )),
                new Email(array(
                    'message' => 'The e-mail is not valid'
                ))
            ));

            $this->add($email);

            // Password
            $password = new Password('password');

            $password->setLabel('Password');

            $password->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The password is required'
                )),
                new StringLength(array(
                    'min' => 8,
                    'messageMinimum' => 'Password is too short. Minimum 8 characters'
                )),
                new Confirmation(array(
                    'message' => 'Password doesn\'t match confirmation',
                    'with' => 'confirmPassword'
                ))
            ));

            $this->add($password);

            // Confirm Password
            $confirmPassword = new Password('confirmPassword');

            $confirmPassword->setLabel('Confirm Password');

            $confirmPassword->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The confirmation password is required'
                ))
            ));

            $this->add($confirmPassword);

            // Location
            $name = new Text('location');

            $name->setLabel('Location');

            $name->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The location is required'
                ))
            ));

            $this->add($name);

            //
            // Remember
            $terms = new Check('terms', array(
                'value' => 'yes'
            ));

            $terms->setLabel('Accept terms and conditions');

            $terms->addValidator(new Identical(array(
                'value' => 'yes',
                'message' => 'Terms and conditions must be accepted'
            )));

            $this->add($terms);

            // CSRF
            /*        $csrf = new Hidden('csrf');

                    $csrf->addValidator(new Identical(array(
                        'value' => $this->security->getSessionToken(),
                        'message' => 'CSRF validation failed'
                    )));

                    $this->add($csrf);
            */

            // Sign Up
            $this->add(new Submit('Sign Up', array(
                'class' => 'btn btn-success'
            )));
        }

        /**
         * Prints messages for a specific element
         */
        public
        function messages($name)
        {
            if ($this->hasMessagesFor($name)) {
                foreach ($this->getMessagesFor($name) as $message) {
                    $this->flash->error($message);
                }
            }
        }
    }
