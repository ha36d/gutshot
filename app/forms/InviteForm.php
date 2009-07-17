<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class InviteForm extends Form
{


    public function initialize()
    {

        $email = new Text('email', array(
            'placeholder' => 'E-mail'
        ));
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The E-mail is required.'
            )),
            new Email(array(
                'message' => 'The E-mail is not valid.'
            )),
        ));

        $this->add($email);

        $this->add(new Submit('Send', array(
            'class' => 'btn btn-primary'
        )));
    }
}
