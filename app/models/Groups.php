<?php
namespace Gutshot\Models;

use Phalcon\Mvc\Model;

/**
 * Gutshot\Models\Groups
 * All the group levels in the application. Used in conjenction with ACL lists
 */
class Groups extends Model
{

    /**
     * ID
     * @var integer
     */
    public $id;

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Define relationships to Users and Permissions
     */
    public function initialize()
    {
        $this->hasMany('id', __NAMESPACE__ . '\Users', 'groupsId', array(
            'alias' => 'users',
            'foreignKey' => array(
                'message' => 'Group cannot be deleted because it\'s used on Users'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\Permissions', 'groupsId', array(
            'alias' => 'permissions'
        ));
    }
}
