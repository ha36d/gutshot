<?php
namespace Gutshot\Controllers;

use Gutshot\Models\Groups;
use Gutshot\Models\Permissions;

/**
 * View and define permissions for the various group levels.
 */
class PermissionsController extends ControllerBase
{

    /**
     * View the permissions for a group level, and change them if we have a POST.
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('private');

        if ($this->request->isPost()) {

            // Validate the group
            $group = Groups::findFirstById($this->request->getPost('groupId'));

            if ($group) {

                if ($this->request->hasPost('permissions')) {

                    // Deletes the current permissions
                    $group->getPermissions()->delete();

                    // Save the new permissions
                    foreach ($this->request->getPost('permissions') as $permission) {

                        $parts = explode('.', $permission);

                        $permission = new Permissions();
                        $permission->groupsId = $group->id;
                        $permission->resource = $parts[0];
                        $permission->action = $parts[1];

                        $permission->save();
                    }

                    $this->flash->success('Permissions were updated with success');
                }

                // Rebuild the ACL with
                $this->acl->rebuild();

                // Pass the current permissions to the view
                $this->view->permissions = $this->acl->getPermissions($group);
            }

            $this->view->group = $group;
        }

        // Pass all the active groups
        $this->view->groups = Groups::find('active = "Y"');
    }
}
