<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * SuccessLogins
 * This model registers successfull logins registered users have made
 */
class SuccessLogins extends Model
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
    public $ipAddress;

    /**
     *
     * @var string
     */
    public $userAgent;

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
            'alias' => 'user'
        ));
    }
}
