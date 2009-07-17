<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Models\Articles;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\ArticlesForm;
use Gutshot\Models\Support;

/**
 * Gutshot\Controllers\GroupsController
 * CRUD to manage groups
 */
class ArticlesController extends ControllerBase
{

    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * search action, shows the search form
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new ArticlesForm();
    }

    /**
     * @param $input
     * announce a news to users
     */
    public function indexAction($input = null)
    {
        if (!empty($input)) {
            $types = array('news', 'rules', 'faq', 'instruction', 'prize');
            if (in_array($input, $types)) {
                $parameters = array(
                    "conditions" => "type = '" . $input . "'",
                    "order" => "createdAt",
                );
                $articles = Articles::find($parameters);
                $this->view->page = $articles;
                $this->view->types = $types;
                $this->view->active = $input;
            } elseif (is_numeric($input)) {
                $article = Articles::findFirstById($input);
                if (!$article) {
                    $this->flash->error("Article was not found");
                    $this->dispatcher->forward(array(
                        'action' => 'index'
                    ));
                }
                $this->view->article = $article;
                $this->view->type = $article->type;
            } else {
                $this->flash->error("Article was not found");
                $this->dispatcher->forward(array(
                    'action' => 'index'
                ));
            }
        } else {
            $this->dispatcher->forward(array(
                'action' => 'index',
                'params' => array('news')
            ));
        }

    }

    /**
     * publish news
     */
    public function createAction()
    {
        if ($this->request->isPost()) {
            $support = new Articles();
            $usersId = $this->auth->getId();
            $post = array(
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'usersId' => $usersId,
                'type' => $this->request->getPost('type'),
            );
            $support->assign($post);
            if (!$support->save()) {
                foreach ($support->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flashSession->success("Article was created successfully");
                $this->response->redirect('articles/list');
            }
        }
        $this->view->form = new ArticlesForm();
    }

    /**
     * @param $id
     * Delete Article
     */
    public function deleteAction($id)
    {
        $support = Articles::findFirstById($id);
        if (!$support) {
            $this->flashSession->error("Article was not found");
            $this->response->redirect('articles/list');
        }
        if (!$support->delete()) {
            foreach ($support->getMessages() as $error) {
                $this->flashSession->error($error);
            }
        } else {
            $this->flashSession->success("User was deleted");
        }
        $this->response->redirect('articles/list');
    }

    /**
     * @param $id
     * edit article
     */
    public function editAction($id)
    {
        $support = Articles::findFirstById($id);
        if (!$support) {
            $this->flashSession->error("Article was not found");
            $this->response->redirect('articles/list');
        }
        if ($this->request->isPost()) {
            $usersId = $this->auth->getId();
            $post = array(
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'usersId' => $usersId,
                'type' => $this->request->getPost('type'),
            );
            $support->assign($post);
            if (!$support->save()) {
                foreach ($support->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flashSession->success("Article was updated successfully");
                $this->response->redirect('articles/list');
            }
        }
        $this->view->form = new ArticlesForm($support, array(
            'edit' => true
        ));
    }

    /**
     * list of all articles
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Articles', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $supports = Articles::find($parameters);

        $paginator = new Paginator(array(
            "data" => $supports,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    public function splashAction()
    {
        if ($this->request->isPost()) {
            $post = array(
                'content' => $this->request->getPost('content'),
                'type' => $this->request->getPost('type'),
            );
            $params = array("Command" => "SystemSet",
                "Property" => "SiteNews",
                "Value" => $post["content"],
            );
            $Firstapi = $this->getDI()->getApi()->poker($params);
            if ($Firstapi->Result == "Ok") {
                $params = array("Command" => "SystemSet",
                    "Property" => "SiteNewsShow",
                    "Value" => $post["type"],
                );
                $Secondapi = $this->getDI()->getApi()->poker($params);
                if ($Secondapi->Result == "Ok") {
                    $this->flash->success("Message was updated successfully");
                    $this->response->redirect('articles/list');
                } else {
                    $this->flash->error($Secondapi->Error);
                }
            } else {
                $this->flash->error($Firstapi->Error);
            }

        }
    }
}
