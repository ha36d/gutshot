<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\GroupsForm;
use Gutshot\Models\Groups;
use Gutshot\Models\Permissions;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class GroupsController extends ControllerBase
{

    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Searches for groups
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new GroupsForm();
    }

    /**
     * Default action, shows the search form
     */
    public function listAction()
    {
        $parameters = array();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Groups', $this->request->getPost());
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $groups = Groups::find($parameters);

        $paginator = new Paginator(array(
            "data" => $groups,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a new Group
     */
    public function createAction()
    {
        if ($this->request->isPost()) {

            $group = new Groups();

            $group->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ));

            if (!$group->save()) {
                foreach ($group->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flash->success("Group was created successfully");
                $this->response->redirect('groups/list');
            }
        }
        $this->view->form = new GroupsForm(null);
    }

    /**
     * Edits an existing Group
     *
     * @param int $id
     */
    public function editAction($id)
    {
        $group = Groups::findFirstById($id);
        if (!$group) {
            $this->flash->error("Group was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }

        if ($this->request->isPost()) {

            $group->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'active' => $this->request->getPost('active')
            ));

            if (!$group->save()) {
                foreach ($group->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flash->success("Group was updated successfully");
            }
            $this->response->redirect('groups/list');
        }
        $this->view->form = new GroupsForm($group, array(
            'edit' => true
        ));

        $this->view->group = $group;
    }

    /**
     * Deletes a Group
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $group = Groups::findFirstById($id);
        if (!$group) {

            $this->flash->error("Group was not found");

            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }

        if (!$group->delete()) {
            foreach ($group->getMessages() as $error) {
                $this->flash->error($error);
            }
        } else {
            $this->flash->success("Group was deleted");
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    public function permissionsAction()
    {
        $this->view->setTemplateBefore('private');

        if ($this->request->isPost()) {

            // Validate the group
            $groupsId = $this->request->getPost('groupsId');
            $group = Groups::findFirstById($groupsId);

            if ($group) {

                if ($groupsId == $this->request->getPost('groupId')) {

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

                        $this->flashSession->success('Permissions were updated with success');
                        $this->response->redirect('groups/permissions');
                    }
                }
                else
                    $this->view->groupId = $group->id;

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
