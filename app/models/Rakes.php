<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * Rakes
 * Rake the inviter user when a user wins a pot
 */
class Rakes extends Model
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
    public $fromId;

    /**
     *
     * @var integer
     */
    public $toId;
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
     * @var string
     */
    public $name;
    /**
     *
     * @var integer
     */
    public $hand;
    /**
     *
     * @var string
     */
    public $status;
    /**
     *
     * @var integer
     */
    public $createdAt;

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
        $this->belongsTo('fromId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'usersIn'
        ));
        $this->belongsTo('toId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'usersOut'
        ));
    }
}
