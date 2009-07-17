<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * PasswordChanges
 * Register when a user changes his/her password
 */
class Transfers extends Model
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
            'alias' => 'userOut'
        ));
        $this->belongsTo('toId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'userIn'
        ));
    }
}
