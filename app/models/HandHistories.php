<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 *
 * Log Users Play
 */
class HandHistories extends Model
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
    public $player;
    /**
     *
     * @var string
     */
    public $type;
    /**
     *
     * @var string
     */
    public $hand;
    /**
     *
     * @var integer
     */
    public $hand_value;
    /**
     *
     * @var integer
     */
    public $name;
    /**
     *
     * @var integer
     */
    public $hand_number;
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
     * Before record added
     */
    public function beforeValidationOnCreate()
    {
        // Timestamp the confirmaton
        $this->createdAt = time();
    }

    public function initialize()
    {
    }
}
