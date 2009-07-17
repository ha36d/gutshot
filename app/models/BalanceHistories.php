<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 *
 * Log Users Play
 */
class BalanceHistories extends Model
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
    public $amountChange;
    /**
     *
     * @var string
     */
    public $amountBalance;
    /**
     *
     * @var string
     */
    public $src;
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
