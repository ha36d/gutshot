<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Gutshot\Models\Users
 * All the users registered in the application
 */
class Users extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $player;

    /**
     *
     * @var integer
     */
    public $xp;

    /**
     *
     * @var integer
     */
    public $level;

    /**
     *
     * @var integer
     */
    public $rake;

    /**
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $mustChangePassword;

    /**
     *
     * @var string
     */
    public $groupsId;

    /**
     *
     * @var string
     */
    public $location;

    /**
     *
     * @var integer
     */
    public $avatar;

    /**
     *
     * @var integer
     */
    public $chat;

    /**
     *
     * @var integer
     */
    public $inviterId;
    /**
     *
     * @var string
     */
    public $account;
    /**
     *
     * @var string
     */
    public $holder;
    /**
     *
     * @var string
     */
    public $bank;
    /**
     *
     * @var integer
     */
    public $card;
    /**
     *
     * @var integer
     */
    public $shaba;
    /**
     *
     * @var integer
     */
    public $pin;
    /**
     *
     * @var string
     */
    public $banned;

    /**
     *
     * @var string
     */
    public $suspended;

    /**
     *
     * @var string
     */
    public $active;

    /**
     *
     * @var string
     */
    public $createdAt;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // The account is not suspended by default
        $this->suspended = 'N';

        // The account is not banned by default
        $this->banned = 'N';

        // The account PIN number
        $this->pin = mt_rand(1000, 9999);

        // Timestamp the confirmaton
        $this->createdAt = time();
    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */
    public function afterSave()
    {
        if ($this->active == 'N') {

            $emailConfirmation = new EmailConfirmations();

            $emailConfirmation->usersId = $this->id;

            if ($emailConfirmation->save()) {
                $this->getDI()
                    ->getFlash()
                    ->notice('A confirmation mail has been sent to ' . $this->email);
            }
        }
    }

    /**
     * Validate that emails are unique across users
     */
    public function validation()
    {
        $this->validate(new Uniqueness(array(
            "field" => "email",
            "message" => "The email is already registered"
        )));

        $this->validate(new Uniqueness(array(
            "field" => "player",
            "message" => "The player is already registered"
        )));

        return $this->validationHasFailed() != true;
    }

    public function initialize()
    {
        $this->belongsTo('groupsId', __NAMESPACE__ . '\Groups', 'id', array(
            'alias' => 'group',
            'reusable' => true
        ));

        $this->hasMany('id', __NAMESPACE__ . '\SuccessLogins', 'usersId', array(
            'alias' => 'successLogins',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\PasswordChanges', 'usersId', array(
            'alias' => 'passwordChanges',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\ResetPasswords', 'usersId', array(
            'alias' => 'resetPasswords',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\Invitations', 'usersId', array(
            'alias' => 'invitations',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\Honors', 'usersId', array(
            'alias' => 'honors',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));
    }
}
