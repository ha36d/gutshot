<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * PasswordChanges
 * Register when a user changes his/her password
 */
class Deposits extends Model
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
    public $status;

    /**
     *
     * @var integer
     */
    public $ref;

    /**
     *
     * @var integer
     */
    public $createdAt;

    /**
     *
     * @var string
     */
    public $type;

    /**
     *
     * @var string
     */
    public $operator;
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
