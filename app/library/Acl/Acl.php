<?php
namespace Gutshot\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use Gutshot\Models\Groups;

/**
 * Gutshot\Acl\Acl
 */
class Acl extends Component
{

    /**
     * The ACL Object
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    private $acl;

    /**
     * The filepath of the ACL cache file from APP_DIR
     *
     * @var string
     */
    private $filePath = '/cache/acl/data.txt';

    /**
     * Define the resources that are considered "private". These controller => actions require authentication.
     *
     * @var array
     */
    private $privateResources = array(
        'game' => array(
            'index',
            'wide',
        ),
        'deposits' => array(
            'search',
            'list',
            'change',
            'index',
            'back',
        ),
        'transfers' => array(
            'search',
            'list',
            'index',
        ),
        'rakes' => array(
            'search',
            'list',
            'index',
            'done',
        ),
        'cashouts' => array(
            'search',
            'list',
            'pay',
            'index',
            'reject',
            'cancel',
        ),
        'support' => array(
            'list',
            'new',
            'compose',
            'conversation',
            'support',
            'clear',
        ),
        'articles' => array(
            'search',
            'list',
            'create',
            'delete',
            'edit',
            'splash',
            'index',
        ),
        'rings' => array(
            'search',
            'list',
            'edit',
            'delete',
            'create',
            'offline',
            'online',
            'index',
            'cancel',
            'accept',
            'reject',
            'pause',
            'resume',
            'message'
        ),
        'tourneys' => array(
            'search',
            'list',
            'create',
            'edit',
            'delete',
            'online',
            'offline',
            'offlineNow',
            'removeNoShows',
            'start',
            'pause',
            'resume',
            'message',
            'register',
            'unregister'
        ),
        'honors' => array(
            'search',
            'list',
            'give',
            'champions',
            'won',
            'played',
            'level',
            'compute',
            'prizes',
            'done'
        ),
        'users' => array(
            'search',
            'list',
            'create',
            'edit',
            'delete',
            'changePassword',
            'profile',
            'account',
            'pinResend'
        ),
        'groups' => array(
            'search',
            'list',
            'create',
            'edit',
            'delete',
            'permissions'
        ),
        'system' => array(
            'status',
            'user',
            'logError',
            'logEvent',
            'logHandHistory',
            'logHandCache',
            'ringDetails',
            'tournamentDetails',
            'tournamentResult',
            'Connections',
            'handValue',
            'logins',
            'balance'
        )
    );

    /**
     * Human-readable descriptions of the actions used in {@see $privateResources}
     *
     * @var array
     */
    private $actionDescriptions = array(
        'index' => 'Access',
        'search' => 'Search',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'list' => 'List',
        'changePassword' => 'Change password'
    );

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    public function isPrivate($controllerName)
    {
        $controllerName = strtolower($controllerName);
        return isset($this->privateResources[$controllerName]);
    }

    /**
     * Checks if the current group is allowed to access a resource
     *
     * @param string $group
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($group, $controller, $action)
    {
        return $this->getAcl()->isAllowed($group, $controller, $action);
    }

    /**
     * Returns the ACL list
     *
     * @return Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // Check if the ACL is in APC
        if (function_exists('apc_fetch')) {
            $acl = apc_fetch('gutshot-acl');
            if (is_object($acl)) {
                $this->acl = $acl;
                return $acl;
            }
        }

        // Check if the ACL is already generated
        if (!file_exists(APP_DIR . $this->filePath)) {
            $this->acl = $this->rebuild();
            return $this->acl;
        }

        // Get the ACL from the data file
        $data = file_get_contents(APP_DIR . $this->filePath);
        $this->acl = unserialize($data);

        // Store the ACL in APC
        if (function_exists('apc_store')) {
            apc_store('gutshot-acl', $this->acl);
        }

        return $this->acl;
    }

    /**
     * Returns the permissions assigned to a group
     *
     * @param Groups $group
     * @return array
     */
    public function getPermissions(Groups $group)
    {
        $permissions = array();
        foreach ($group->getPermissions() as $permission) {
            $permissions[$permission->resource . '.' . $permission->action] = true;
        }
        return $permissions;
    }

    /**
     * Returns all the resoruces and their actions available in the application
     *
     * @return array
     */
    public function getResources()
    {
        return $this->privateResources;
    }

    /**
     * Returns the action description according to its simplified name
     *
     * @param string $action
     * @return $action
     */
    public function getActionDescription($action)
    {
        if (isset($this->actionDescriptions[$action])) {
            return $this->actionDescriptions[$action];
        } else {
            return $action;
        }
    }

    /**
     * Rebuilds the access list into a file
     *
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function rebuild()
    {
        $acl = new AclMemory();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        // Register roles
        $groups = Groups::find('active = "Y"');

        foreach ($groups as $group) {
            $acl->addRole(new AclRole($group->name));
        }

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

        // Grant acess to private area to role Users
        foreach ($groups as $group) {

            // Grant permissions in "permissions" model
            foreach ($group->getPermissions() as $permission) {
                $acl->allow($group->name, $permission->resource, $permission->action);
            }
        }

        if (touch(APP_DIR . $this->filePath) && is_writable(APP_DIR . $this->filePath)) {

            file_put_contents(APP_DIR . $this->filePath, serialize($acl));

            // Store the ACL in APC
            if (function_exists('apc_store')) {
                apc_store('gutshot-acl', $acl);
            }
        } else {
            $this->flash->error(
                'The user does not have write permissions to create the ACL list at ' . APP_DIR . $this->filePath
            );
        }

        return $acl;
    }
}
