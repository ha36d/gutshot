<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;

class PrivateRingsForm extends Form
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

        $this->add(new Select('game', array("Limit Hold'em" => "Limit Hold'em",
            "Pot Limit Hold'em" => "Pot Limit Hold'em",
            "No Limit Hold'em" => "No Limit Hold'em",
            "Limit Omaha" => "Limit Omaha",
            "Pot Limit Omaha" => "Pot Limit Omaha",
            "No Limit Omaha" => "No Limit Omaha",
            "Limit Omaha Hi-Lo" => "Limit Omaha Hi-Lo",
            "Pot Limit Omaha Hi-Lo" => "Pot Limit Omaha Hi-Lo",
            "No Limit Omaha Hi-Lo" => "No Limit Omaha Hi-Lo"),
            array(
                'useEmpty' => false,
            )
        ));

        $password = new Text('pw', array(
            'placeholder' => 'Password'
        ));

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'The password is required'
            )),
        ));

        $this->add($password);


        $seats = new Select('seats', array(
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ),
            array(
                'useEmpty' => false,
            ));

        $seats->addValidators(array(
            new PresenceOf(array(
                'message' => 'The number of seats is required'
            ))
        ));

        $this->add($seats);

        $plan = new Select('plan', array(
            '1' => 'Minimum Buy in: 40000, Maximum Buy in: 200000, Small Blind: 1000, Big Blind: 2000',
            '2' => 'Minimum Buy in: 200000, Maximum Buy in: 1000000, Small Blind: 5000, Big Blind: 10000',
            '3' => 'Minimum Buy in: 1000000, Maximum Buy in: 5000000, Small Blind: 25000, Big Blind: 50000',
        ),
            array(
                'useEmpty' => false,
            ));

        $plan->addValidators(array(
            new PresenceOf(array(
                'message' => 'The plan is required'
            ))
        ));

        $this->add($plan);

        $speed = new Select('speed', array(
            '1' => 'General: Action Time: 30s, Sitout Minutes: 10',
            '2' => 'Fast: Action Time: 15s, Sitout Minutes: 5'
        ),
            array(
                'useEmpty' => false,
            ));

        $speed->addValidators(array(
            new PresenceOf(array(
                'message' => 'The speed is required'
            ))
        ));

        $this->add($speed);

    }
}
