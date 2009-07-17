<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * Rakes
 * Rake the inviter user when a user wins a pot
 */
class Support extends Model
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
    public $content;
    /**
     *
     * @var integer
     */
    public $fromStatus;
    /**
     *
     * @var string
     */
    public $type;
    /**
     *
     * @var string
     */
    public $toStatus;
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
        $this->belongsTo('usersId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'users'
        ));
    }
}
