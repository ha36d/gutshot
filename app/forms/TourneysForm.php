<?php
namespace Gutshot\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\PresenceOf;

class TourneysForm extends Form
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

        $shootout = new Select('shootout', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'No',
                'useEmpty' => false,
            ));
        $shootout->addValidators(array(
            new PresenceOf(array(
                'message' => 'The shootout is required'
            )),
        ));
        $this->add($shootout);

        $description = new Text('description', array(
            'placeholder' => 'Description'
        ));
        $description->addValidators(array(
            new PresenceOf(array(
                'message' => 'Description is required'
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

        $perm_register = new Text('perm_register', array(
            'value' => ''
        ));
        $perm_register->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_register);

        $perm_unregister = new Text('perm_unregister', array(
            'value' => ''
        ));
        $perm_unregister->addValidators(array(
            new StringLength(array(
                'max' => 15,
                'messageMaximum' => 'It must be less than 15 characters',
            ))));
        $this->add($perm_unregister);

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

        $tables = new Text('tables', array(
            'value' => 1
        ));
        $this->add($tables);

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

        $start_full = new Select('start_full', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => 'Yes',
                'useEmpty' => false,
            ));
        $this->add($start_full);


        $start_min = new Text('start_min', array(
            'value' => 0
        ));
        $this->add($start_min);

        $start_code = new Text('start_code', array(
            'value' => 0
        ));
        $this->add($start_code);

        $start_time = new Text('start_time', array(
            'value' => '0000-00-00 00:00'
        ));
        $this->add($start_time);

        $reg_period = new Text('reg_period', array(
            'value' => 0
        ));
        $this->add($reg_period);

        $late_reg_minutes = new Text('late_reg_minutes', array(
            'value' => 0
        ));
        $this->add($late_reg_minutes);

        $min_players = new Text('min_players', array(
            'value' => 2
        ));
        $this->add($min_players);

        $recur_minutes = new Text('recur_minutes', array(
            'value' => 0
        ));
        $this->add($recur_minutes);

        $no_show_minutes = new Text('no_show_minutes', array(
            'value' => 0
        ));
        $this->add($no_show_minutes);

        $buy_in = new Text('buy_in', array(
            'value' => 1500
        ));
        $this->add($buy_in);

        $entry_fee = new Text('entry_fee', array(
            'value' => 0
        ));
        $this->add($entry_fee);

        $prize_bonus = new Text('prize_bonus', array(
            'value' => 0
        ));
        $this->add($prize_bonus);

        $multiply_bonus = new Select('multiply_bonus', array(
            'Yes' => 'Yes',
            'No' => 'No',
            'Min' => 'Min',
        ),
            array(
                'value' => 'Yes',
                'useEmpty' => false,
            ));
        $this->add($multiply_bonus);

        $chips = new Text('chips', array(
            'value' => 1500
        ));
        $this->add($chips);

        $add_on_chips = new Text('add_on_chips', array(
            'value' => 0
        ));
        $this->add($add_on_chips);

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

        $level = new Text('level', array(
            'value' => 10
        ));
        $this->add($level);

        $rebuy_levels = new Text('rebuy_levels', array(
            'value' => 0
        ));
        $this->add($rebuy_levels);

        $threshold = new Text('threshold', array(
            'value' => 1500
        ));
        $this->add($threshold);

        $max_rebuys = new Text('max_rebuys', array(
            'value' => 0
        ));
        $this->add($max_rebuys);

        $rebuy_cost = new Text('rebuy_cost', array(
            'value' => 0
        ));
        $this->add($rebuy_cost);

        $rebuy_fee = new Text('rebuy_fee', array(
            'value' => 0
        ));
        $this->add($rebuy_fee);

        $break_time = new Text('break_time', array(
            'value' => 0
        ));
        $this->add($break_time);

        $break_levels = new Text('break_levels', array(
            'value' => 0
        ));
        $this->add($break_levels);

        $stop_on_chop = new Select('stop_on_chop', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => "No",
                'useEmpty' => false,
            ));
        $this->add($stop_on_chop);


        $blinds = new Text('blinds', array(
            'value' => '10/20/0, 15/30/0, 25/50/0, 50/100/0, 75/150/0, 100/200/0, 100/200/25, 200/400/25, 300/600/50, 400/800/50, 600/1200/75, 800/1600/75, 1000/2000/100, 1500/3000/150, 2000/4000/200, 3000/6000/300, 4000/8000/400, 6000/12000/600, 8000/16000/800, 10000/20000/1000, 15000/30000/1500, 20000/40000/2000, 25000/50000/2500, 35000/70000/3500, 45000/90000/4500, 55000/110000/5500, 70000/140000/7000, 85000/170000/8500, 100000/200000/10000, 125000/250000/12500'
        ));
        $this->add($blinds);

        $payout = new Text('payout', array(
            'value' => '2-4, 100.00|5-7, 65.00, 35.00|8-10, 50.00, 30.00, 20.00|11-20, 45.00, 28.00, 17.00, 10.00|21-40, 36.00, 23.00, 15.00, 11.00, 8.00, 7.00|41-70, 30.00, 20.00, 14.00, 10.00, 8.00, 7.00, 6.00, 5.00|71-100, 29.00, 18.00, 12.50, 10.00, 8.00, 6.50, 5.50, 4.50, 3.50, 2.50|101-200, 28.00, 17.50, 11.50, 8.50, 7.00, 5.50, 4.50, 3.50, 2.50, 1.50, 1.00x10|201-400, 27.00, 16.50, 10.50, 8.00, 6.25, 4.75, 3.75, 2.75, 1.75, 1.25, 0.75x10, 0.50x20|401-700, 26.00, 15.50, 10.00, 7.50, 6.00, 4.50, 3.50, 2.50, 1.50, 1.00, 0.65x10, 0.40x20, 0.25x30|701-1000, 25.00, 15.00, 10.00, 7.25, 5.50, 4.25, 3.25, 2.25, 1.25, 0.75, 0.55x10, 0.40x20, 0.25x30, 0.15x30'
        ));
        $this->add($payout);

        $unreg_logout = new Select('unreg_logout', array(
            'Yes' => 'Yes',
            'No' => 'No',
        ),
            array(
                'value' => "No",
                'useEmpty' => false,
            ));
        $this->add($unreg_logout);

    }
}
