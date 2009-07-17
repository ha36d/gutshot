<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email;
use Gutshot\Models\Groups;

class UsersForm extends Form
{

    public function initialize($entity = null, $options = null)
    {

        // In edition the id is hidden
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

        if (isset($options['edit']) && $options['edit']) {
            $player = new Hidden('player');
        } else {
            $player = new Text('player', array(
                'placeholder' => 'Player',
            ));

            $player->addValidators(array(
                new PresenceOf(array(
                    'message' => 'The name is required'
                ))
            ));
        }
        $this->add($player);

        $name = new Text('name', array(
            'placeholder' => 'Name'
        ));

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            ))
        ));

        $this->add($name);

        $email = new Text('email', array(
            'placeholder' => 'Email'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        $this->add(new Select('groupsId', Groups::find('active = "Y"'), array(
            'using' => array(
                'id',
                'name'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $title = new Text('title', array(
            'placeholder' => 'Title',
        ));

        $this->add($title);

        $this->add(new Select('gender', array(
            "Male" => "Male",
            "Female" => "Female",
        ), array(
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

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
        ));

        $this->add($password);

        $location = new Text('location', array(
            'placeholder' => 'Location',
        ));
        $location->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Location is required'
            )),
        ));
        $this->add($location);

        $card = new Text('card', array(
            'placeholder' => 'Card Number'
        ));
        $card->addValidators(array(
            new PresenceOf(array(
                'message' => 'The card number is required'
            )),
        ));
        $this->add($card);

        $account = new Text('account', array(
            'placeholder' => 'Account Number'
        ));
        $this->add($account);

        $holder = new Text('holder', array(
            'placeholder' => 'Holder Name'
        ));
        $holder->addValidators(array(
            new PresenceOf(array(
                'message' => 'The holder name is required'
            )),
        ));
        $this->add($holder);

        $bank = new Text('bank', array(
            'placeholder' => 'Bank Name'
        ));
        $bank->addValidators(array(
            new PresenceOf(array(
                'message' => 'The bank name is required'
            )),
        ));
        $this->add($bank);

        $shaba = new Text('shaba', array(
            'placeholder' => 'Shaba Number'
        ));
        $shaba->addValidators(array(
            new PresenceOf(array(
                'message' => 'The Shaba number is required'
            )),
        ));
        $this->add($shaba);

        $code = new Text('code', array(
            'placeholder' => 'Pin Code',
        ));
        $code->addValidators(array(
            new PresenceOf(array(
                'message' => 'The pin is required'
            )),
        ));
        $this->add($code);

        $this->add(new Select('banned', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('suspended', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        $this->add(new Select('active', array(
            'Y' => 'Yes',
            'N' => 'No'
        )));

        //Avatar
        $avatarmax = 64;       // number of avatars available

        for ($i = 1; $i <= $avatarmax; $i++) {
            $this->add(new Radio('avatar' . $i, array(
                'name' => 'Avatar',
                'value' => $i
            )));
        }

    }
}
