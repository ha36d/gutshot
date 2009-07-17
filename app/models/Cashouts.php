<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * PasswordChanges
 * Register when a user changes his/her password
 */
class Cashouts extends Model
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
    public $usersId;
    /**
     *
     * @var integer
     */
    public $account;
    /**
     *
     * @var string
     */
    public $holder;
    /**
     *
     * @var integer
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
     * @var string
     */
    public $comment;
    /**
     *
     * @var integer
     */
    public $amount;
    /**
     *
     * @var integer
     */
    public $createdAt;
    /**
     *
     * @var integer
     */
    public $paidAt;
    /**
     *
     * @var string
     */
    public $status;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();
    }

    public function initialize()
    {
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'user'
        ));
    }
}
