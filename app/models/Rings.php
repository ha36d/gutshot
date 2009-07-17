<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Gutshot\Models\Users
 * All the users registered in the application
 */
class Rings extends Model
{

    /**
     *
     * @var string
     */
    public $id;
    /**
     *
     * @var string
     */
    public $name;
    /**
     *
     * @var string
     */
    public $description;
    /**
     *
     * @var string
     */
    public $auto_online;
    /**
     *
     * @var string
     */
    public $game;
    /**
     *
     * @var string
     */
    public $pw;
    /**
     *
     * @var string
     */
    public $private;
    /**
     *
     * @var string
     */
    public $perm_play;
    /**
     *
     * @var string
     */
    public $perm_observe;
    /**
     *
     * @var string
     */
    public $perm_player_chat;
    /**
     *
     * @var string
     */
    public $perm_observer_chat;
    /**
     *
     * @var string
     */
    public $suspend_chat_all_in;
    /**
     *
     * @var string
     */
    public $seats;
    /**
     *
     * @var string
     */
    public $smallest_chip;
    /**
     *
     * @var string
     */
    public $minimum_buy_in;
    /**
     *
     * @var string
     */
    public $maximum_buy_in;
    /**
     *
     * @var string
     */
    public $default_buy_in;
    /**
     *
     * @var string
     */
    public $plan;
    /**
     *
     * @var string
     */
    public $rake;
    /**
     *
     * @var string
     */
    public $rake_every;
    /**
     *
     * @var string
     */
    public $rake_max;
    /**
     *
     * @var string
     */
    public $turn_clock;
    /**
     *
     * @var string
     */
    public $time_bank;
    /**
     *
     * @var string
     */
    public $bank_reset;
    /**
     *
     * @var string
     */
    public $dis_protect;
    /**
     *
     * @var string
     */
    public $small_blind;
    /**
     *
     * @var string
     */
    public $big_blind;
    /**
     *
     * @var string
     */
    public $dupe_ips;
    /**
     *
     * @var string
     */
    public $rathole_minutes;
    /**
     *
     * @var string
     */
    public $sitout_minutes;
    /**
     *
     * @var string
     */
    public $sitout_relaxed;
    /**
     *
     * @var string
     */
    public $speed;
    /**
     *
     * @var string
     */
    public $status;
    /**
     *
     * @var integer
     */
    public $usersId;
    /**
     *
     * @var integer
     */
    public $createdAt;

    public function beforeValidationOnCreate()
    {
        // Timestamp the successful login
        $this->createdAt = time();
    }

    public function initialize()
    {
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'user',
        ));

    }
}
