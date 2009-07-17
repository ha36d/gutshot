<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * Rakes
 * Rake the inviter user when a user wins a pot
 */
class Articles extends Model
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
    public $title;
    /**
     *
     * @var string
     */
    public $content;
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
            'alias' => 'users'
        ));
    }
}
