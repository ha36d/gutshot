<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Between;
use Gutshot\Models\Users;


class CashoutsForm extends Form
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
                'minimum' => 10000,
                'maximum' => 99000000,
                'message' => 'The amount must be between 10000 and 99000000'
            ))
        ));
        $this->add($amount);

        $this->add(new Select('usersId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => ''
        )));

        $this->add(new Select('status', array("Yes" => "Paid",
            "No" => "Pending",
            "Cancel" => "Cancel",
            "Reject" => "Reject",
        ),
            array(
                'useEmpty' => false,
                'value' => 'News'
            )
        ));

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);

        $paidAtFrom = new Text('paidAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($paidAtFrom);

        $paidAtTo = new Text('paidAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($paidAtTo);
    }
}
