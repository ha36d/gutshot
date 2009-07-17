<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Between;
use Gutshot\Models\Users;


class TransfersForm extends Form
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

        $fromId = new Select('fromId', Users::find(), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
        ));
        $this->add($fromId);

        $toId = new Select('toId', Users::find(), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
        ));
        $this->add($toId);

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);

        $data_source = array();
        $users = Users::find(array('conditions' => 'active = "Y"', 'columns' => 'player'));
        foreach ($users as $user) {
            $data_source[] = $user->player;
        }

        $usersId = new Text('usersId', array(
            'data-provide' => 'typeahead',
            'autocomplete' => 'off',
            'placeholder' => 'Player',
            'data-source' => json_encode($data_source),
            'data-items' => 3,
            'data-min-length' => 3,
        ));
        $usersId->addValidators(array(
            new PresenceOf(array(
                'message' => 'The player is required'
            ))
        ));
        $this->add($usersId);

        $pin = new Text('code', array(
            'placeholder' => 'Pin Code',
        ));
        $pin->addValidators(array(
            new PresenceOf(array(
                'message' => 'The pin is required'
            )),
        ));
        $this->add($pin);
    }
}
