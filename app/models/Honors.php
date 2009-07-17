<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Gutshot\Models\Users
 * All the users registered in the application
 */
class Honors extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $comment;

    /**
     *
     * @var integer
     */
    public $prize;
    /**
     *
     * @var string
     */
    public $type;

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
            'alias' => 'user',
        ));
    }
}
