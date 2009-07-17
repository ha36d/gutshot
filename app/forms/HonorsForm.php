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

class HonorsForm extends Form
{


    public function initialize()
    {

        $this->add(new Select('usersId', Users::find('active = "Y"'), array(
            'using' => array(
                'id',
                'player'
            ),
            'useEmpty' => true,
            'emptyText' => '...',
            'emptyValue' => '',
        )));

        $prize = new Text('prize', array(
            'placeholder' => 'Toman',
            'value' => 0,
        ));
        $prize->addValidators(array(
            new PresenceOf(array(
                'message' => 'The amount is required'
            )),
            new Regex(array(
                'pattern' => '/^[0-9]+$/',
                'message' => 'The amount is invalid'
            )),
            new Between(array(
                'minimum' => 0,
                'maximum' => 2000000,
                'message' => 'The amount must be between 0 and 10,000,000'
            ))
        ));

        $this->add($prize);

        $this->add(new Select('type', array(
            '1' => 'Most Hands Played of the Week',
            '2' => 'Most Hands Won of the Week',
            '3' => 'Biggest Pots Won of the Week',
            '4' => 'Most Chips Won of the Week',
            '5' => 'Best Winning Hands of the Week',
            '6' => 'Tournament',
            '7' => 'Other',
            '8' => 'LevelUp',
        ), array(
            'useEmpty' => false,
            'value' => '1',
        )));

        $this->add(new Select('place', array(
            '11' => '(1st place)',
            '12' => '(2nd place)',
            '13' => '(3rd place)',
            '14' => '(4th place)',
            '15' => '(5th place)',
            '16' => '(6th place)',
            '17' => '(7th place)',
            '18' => '(8th place)',
            '19' => '(9th place)',
            '20' => '(10th place)',
            '21' => '(11th place)',
            '22' => '(12th place)',
            '23' => '(13th place)',
            '24' => '(14th place)',
            '25' => '(15th place)',
            '26' => '(16th place)',
            '27' => '(17th place)',
            '28' => '(18th place)',
            '29' => '(19th place)',
            '30' => '(20th place)',
        ), array(
            'useEmpty' => false,
            'value' => '11',
        )));

        $comment = new TextArea('comment', array(
            'placeholder' => 'Comment',
        ));
        $this->add($comment);

        $createdAtFrom = new Text('createdAtFrom', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtFrom);

        $createdAtTo = new Text('createdAtTo', array(
            'data-format' => 'dd-MM-yyyy hh:mm:ss'
        ));
        $this->add($createdAtTo);
    }
}
