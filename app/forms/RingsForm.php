<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\PresenceOf;

class RingsForm extends Form
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

        $name = new Text('name', array(
            'placeholder' => 'Name'
        ));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            )),
        ));
        $this->add($name);

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
                'value' => "Limit Hold'em",
                'useEmpty' => false,
            )
        ));

        $description = new Text('description', array(
            'placeholder' => 'Description'
        ));
        $description->addValidators(array(
            new PresenceOf(array(
                'message' => 'The description is required'
            )),
        ));
        $this->add($description);

        $auto = new Select('auto', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'Yes',
                'useEmpty' => false,
            ));
        $auto->addValidators(array(
            new PresenceOf(array(
                'message' => 'The auto is required'
            )),
        ));
        $this->add($auto);

        $pw = new Text('pw', array(
            'placeholder' => 'Password'
        ));
        $this->add($pw);

        $private = new Select('private', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'No',
                'useEmpty' => false,
            ));
        $this->add($private);

        $perm_play = new Text('perm_play', array(
            'value' => ''
        ));
        $perm_play->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_play);

        $perm_observe = new Text('perm_observe', array(
            'value' => ''
        ));
        $perm_observe->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_observe);

        $perm_player_chat = new Text('perm_player_chat', array(
            'value' => ''
        ));
        $perm_player_chat->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_player_chat);

        $perm_observer_chat = new Text('perm_observer_chat', array(
            'value' => ''
        ));
        $perm_observer_chat->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_observer_chat);

        $suspend_chat_all_in = new Select('suspend_chat_all_in', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'No',
                'useEmpty' => false,
            ));
        $this->add($suspend_chat_all_in);

        $seats = new Select('seats', array(
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
        ),
            array(
                'value' => 2,
                'useEmpty' => false,
            ));
        $seats->addValidators(array(
            new PresenceOf(array(
                'message' => 'The number of seats is required'
            ))
        ));
        $this->add($seats);

        $smallest_chip = new Select('smallest_chip', array(
            '0.01' => '0.01',
            '0.05' => '0.05',
            '0.25' => '0.25',
            '1' => '1',
            '5' => '5',
            '100' => '100',
            '500' => '500',
            '1000' => '1000',
            '5000' => '5000',
            '25000' => '25000',
            '100000' => '100000',
            '500000' => '500000',
            '1000000' => '1000000',
            '5000000' => '5000000',
            '25000000' => '25000000',
            '100000000' => '100000000',
            '500000000' => '500000000',
            '1000000000' => '1000000000',
        ),
            array(
                'value' => '1',
                'useEmpty' => false,
            ));
        $this->add($smallest_chip);


        $minimum_buy_in = new Text('minimum_buy_in', array(
            'value' => 400
        ));
        $this->add($minimum_buy_in);

        $maximum_buy_in = new Text('maximum_buy_in', array(
            'value' => 2000
        ));
        $this->add($maximum_buy_in);

        $default_buy_in = new Text('default_buy_in', array(
            'value' => 1200
        ));
        $this->add($default_buy_in);

        $rake = new Text('rake', array(
            'value' => 2,
        ));
        $this->add($rake);

        $rake_every = new Text('rake_every', array(
            'value' => 100,
        ));
        $this->add($rake_every);

        $rake_max = new Text('rake_max', array(
            'value' => 10000
        ));
        $this->add($rake_max);

        $turn_clock = new Text('turn_clock', array(
            'value' => 30
        ));
        $this->add($turn_clock);

        $time_bank = new Text('time_bank', array(
            'value' => 60
        ));
        $this->add($time_bank);

        $bank_reset = new Text('bank_reset', array(
            'value' => 0
        ));
        $this->add($bank_reset);

        $dis_protect = new Select('dis_protect', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'Yes',
                'useEmpty' => false,
            ));
        $this->add($dis_protect);

        $small_blind = new Text('small_blind', array(
            'value' => 10
        ));
        $this->add($small_blind);

        $big_blind = new Text('big_blind', array(
            'value' => 10
        ));
        $this->add($big_blind);

        $dupe_ips = new Select('dupe_ips', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => "No",
                'useEmpty' => false,
            ));
        $this->add($dupe_ips);

        $rathole_minutes = new Text('rathole_minutes', array(
            'value' => 20
        ));
        $this->add($rathole_minutes);

        $sitout_minutes = new Text('sitout_minutes', array(
            'value' => 10
        ));
        $this->add($sitout_minutes);

        $sitout_relaxed = new Select('sitout_relaxed', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => "No",
                'useEmpty' => false,
            ));
        $this->add($sitout_relaxed);
    }
}
