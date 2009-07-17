<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * Permissions
 * Stores the permissions by group
 */
class Permissions extends Model
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
    public $groupsId;

    /**
     *
     * @var string
     */
    public $resource;

    /**
     *
     * @var string
     */
    public $action;

    public function initialize()
    {
        $this->belongsTo('groupsId', __NAMESPACE__ . '\Groups', 'id', array(
            'alias' => 'group'
        ));
    }
}
