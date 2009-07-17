<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Gutshot\Models\Users
 * All the users registered in the application
 */
class Tourneys extends Model
{

    /**
     *
     * @var integer
     */
    public $id;
    /**
     *
     * @var integer
     */
    public $name;
    /**
     *
     * @var integer
     */
    public $game;
    /**
     *
     * @var integer
     */
    public $shootout;
    /**
     *
     * @var integer
     */
    public $description;
    /**
     *
     * @var integer
     */
    public $auto;
    /**
     *
     * @var integer
     */
    public $pw;
    /**
     *
     * @var integer
     */
    public $private;
    /**
     *
     * @var integer
     */
    public $perm_register;
    /**
     *
     * @var integer
     */
    public $perm_unregister;
    /**
     *
     * @var integer
     */
    public $perm_observe;
    /**
     *
     * @var integer
     */
    public $perm_player_chat;
    /**
     *
     * @var integer
     */
    public $perm_observer_chat;
    /**
     *
     * @var integer
     */
    public $suspend_chat_all_in;
    /**
     *
     * @var integer
     */
    public $tables;
    /**
     *
     * @var integer
     */
    public $seats;
    /**
     *
     * @var integer
     */
    public $start_full;
    /**
     *
     * @var integer
     */
    public $start_min;
    /**
     *
     * @var integer
     */
    public $start_code;
    /**
     *
     * @var integer
     */
    public $start_time;
    /**
     *
     * @var integer
     */
    public $reg_period;
    /**
     *
     * @var integer
     */
    public $late_reg_minutes;
    /**
     *
     * @var integer
     */
    public $min_players;
    /**
     *
     * @var integer
     */
    public $recur_minutes;
    /**
     *
     * @var integer
     */
    public $no_show_minutes;
    /**
     *
     * @var integer
     */
    public $buy_in;
    /**
     *
     * @var integer
     */
    public $entry_fee;
    /**
     *
     * @var integer
     */
    public $prize_bonus;
    /**
     *
     * @var integer
     */
    public $multiply_bonus;
    /**
     *
     * @var integer
     */
    public $chips;
    /**
     *
     * @var integer
     */
    public $add_on_chips;
    /**
     *
     * @var integer
     */
    public $turn_clock;
    /**
     *
     * @var integer
     */
    public $time_bank;
    /**
     *
     * @var integer
     */
    public $bank_reset;
    /**
     *
     * @var integer
     */
    public $dis_protect;
    /**
     *
     * @var integer
     */
    public $level;
    /**
     *
     * @var integer
     */
    public $rebuy_levels;
    /**
     *
     * @var integer
     */
    public $threshold;
    /**
     *
     * @var integer
     */
    public $max_rebuys;
    /**
     *
     * @var integer
     */
    public $rebuy_cost;
    /**
     *
     * @var integer
     */
    public $rebuy_fee;
    /**
     *
     * @var integer
     */
    public $break_time;
    /**
     *
     * @var integer
     */
    public $break_levels;
    /**
     *
     * @var integer
     */
    public $stop_on_chop;
    /**
     *
     * @var integer
     */
    public $blinds;
    /**
     *
     * @var integer
     */
    public $payout;
    /**
     *
     * @var integer
     */
    public $unreg_logout;
    /**
     *
     * @var integer
     */
    public $usersId;
    /**
     *
     * @var string
     */
    public $status;


    public function initialize()
    {

    }
}
