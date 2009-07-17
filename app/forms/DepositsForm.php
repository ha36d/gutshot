<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Between;
use Gutshot\Models\Users;


class DepositsForm extends Form
{


    public function initialize()
    {

        $amount = new Text('amount', array(
            'placeholder' => 'Toman'
        ));

        $amount->addValidators(array(
            new PresenceOf(array(
                'message' => 'The amount is required'
            )),
            new Regex(array(
                'pattern' => '/^[0-9]+$/',
                'message' => 'The amount is invalid'
            )),
            new Between(array(
                'minimum' => 1000,
                'maximum' => 1000000,
                'message' => 'The amount must be between 1000 and 1,000,000'
            ))
        ));
        $this->add($amount);

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);

        $this->add(new Select('usersId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $operator = new Text('operator', array(
            'placeholder' => 'User Name'
        ));
        $this->add($operator);

        $this->add(new Select('change', array(
            -1 => 'Decrease',
            1 => 'Increase',
        ), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => false,
            'value' => 1
        )));

        $comment = new TextArea('comment', array(
            'placeholder' => 'Comment'
        ));


        $this->add($comment);
    }
}
