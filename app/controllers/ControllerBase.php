<?php
namespace Gutshot\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Gutshot\Models\Articles;
use Gutshot\Models\HandHistories;
use Gutshot\Models\Groups;
use Gutshot\Models\Users;

/**
 * ControllerBase
 * This is the base controller for all controllers in the application
 */
class ControllerBase extends Controller
{

    /**
     * Execute before the router so we can determine if this is a provate controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        // Get the current identity
        $identity = $this->auth->getIdentity();

        // Only check permissions on private controllers
        if ($this->acl->isPrivate($controllerName)) {

            // If there is no identity available the user is redirected to index/index
            if (!is_array($identity)) {

                $this->flash->notice('You don\'t have access to this section.');

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'index'
                ));
                return false;
            }

            // Check if the user have permission to the current option
            if (!$this->acl->isAllowed($identity['group'], $controllerName, $actionName)) {

                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($identity['group'], $controllerName, 'index')) {
                    $dispatcher->forward(array(
                        'controller' => $controllerName,
                        'action' => 'index'
                    ));
                } else {
                    $dispatcher->forward(array(
                        'controller' => 'user_control',
                        'action' => 'index'
                    ));
                }
                return false;
            }
        }
    }

    /**
     * Execute after the router so we can determine if this is a provate controller, and must be authenticated, or a
     * public controller that is open to all.
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        // Get the current identity
        $identity = $this->auth->getIdentity();

        // publicUrl
        $this->view->setVars(array(
            'publicUrl' => $this->config->application->publicUrl,
        ));

        if (is_array($identity)) {
            $this->blocksRender();
            $this->menusRender($identity['group']);
            if ($controllerName == 'index' && $actionName == 'index') {
                $this->blocksRender();
                $this->menusRender($identity['group']);
            }
        }

    }

    public function blocksRender()
    {
        // Get Top of the last Monday till now
        if (date('l') == "Saturday")
            $duration = strtotime("today");
        else
            $duration = strtotime("last saturday");

        $player = $this->auth->getPlayer();

        $user = Users::findFirstByPlayer($player);

        $number_pot_win = HandHistories::count(
            array(
                "type = 'Yes' AND player = '" . $player . "'",
            )
        );

        $number_played = HandHistories::count(
            array(
                "player = '" . $player . "'",
            )
        );


        $most_hands_played = HandHistories::count(
            array(
                "group" => "player",
                "order" => "rowcount DESC",
                "limit" => 30,
                "createdAt > " . $duration,
            )
        );

        $my_most_hands_played = HandHistories::count(
            array(
                "createdAt > " . $duration . " AND player = '" . $player . "'",
            )
        );

        $most_hands_winners = HandHistories::count(
            array(
                "group" => "player",
                "order" => "rowcount DESC",
                "limit" => 30,
                "type = 'Yes' AND createdAt > " . $duration,
            )
        );

        $my_most_hands_winners = HandHistories::count(
            array(
                "type = 'Yes' AND createdAt > " . $duration . " AND player = '" . $player . "'",
            )
        );

        $most_pot_winners = HandHistories::find(
            array(
                "conditions" => "type = 'Yes' AND createdAt > '" . $duration . "'",
                "order" => "amount DESC",
                "limit" => 30
            )
        );

        $my_most_pot_winners = HandHistories::find(
            array(
                "conditions" => "type = 'Yes' AND createdAt > '" . $duration . "' AND player = '" . $player . "'",
                "order" => "amount DESC",
                "limit" => 3
            )
        );

        $cheap_leaders = HandHistories::sum(
            array(
                "column" => "amount",
                "group" => "player",
                "order" => "sumatory DESC",
                "conditions" => "type = 'Yes' AND createdAt > '" . $duration . "'",
                "limit" => 30
            )
        );

        $my_cheap_leaders = HandHistories::sum(
            array(
                "column" => "amount",
                "conditions" => "type = 'Yes' AND createdAt > '" . $duration . "' AND player = '" . $player . "'",
            )
        );

        $best_hand_winners = HandHistories::find(
            array(
                "columns" => "player, hand",
                "conditions" => "type = 'Yes' AND hand_value > 0 AND createdAt > '" . $duration . "'",
                "order" => "hand_value DESC",
                "limit" => 30
            )
        );

        $my_best_hand_winners = HandHistories::find(
            array(
                "columns" => "hand",
                "conditions" => "type = 'Yes' AND hand_value > 0 AND createdAt > '" . $duration . "' AND player = '" . $player . "'",
                "order" => "hand_value DESC",
                "limit" => 3
            )
        );

        $params = array("Command" => "AccountsGet",
            "Player" => $player,
        );
        $api = $this->getDI()->getApi()->poker($params);
        $this->view->chips = $api;

        $params = array("Command" => "SystemStats",
        );
        $api = $this->getDI()->getApi()->poker($params);
        $this->view->stats = $api;

        $this->view->setVars(
            array('most_hands_played' => $most_hands_played,
                'most_hands_winners' => $most_hands_winners,
                'most_pot_winners' => $most_pot_winners,
                'cheap_leaders' => $cheap_leaders,
                'best_hand_winners' => $best_hand_winners,
                'my_most_hands_played' => $my_most_hands_played,
                'my_most_hands_winners' => $my_most_hands_winners,
                'my_most_pot_winners' => $my_most_pot_winners,
                'my_cheap_leaders' => $my_cheap_leaders,
                'my_best_hand_winners' => $my_best_hand_winners,
                'user' => $user,
                'number_pot_win' => $number_pot_win,
                'number_played' => $number_played
            ));
    }

    public function menusRender($groupId)
    {
        $group = Groups::findFirstByName($groupId);
        $permissions = $this->acl->getPermissions($group);
        $menus = array();
        foreach ($permissions as $permission => $value) {
            $pieces = explode(".", $permission);
            if (!in_array($pieces[1], array("edit", "delete", "offline", "offlineNow", "online", "cancel", "wide", "back", "done", "account", "pay", "changePassword", "clear", "pinResend", "accept", "reject", "message", "start", "pause", "resume", "removeNoShows", "register", "unregister"))) {
                $menu = array($pieces[0] => $pieces[1]);
                $menus = array_merge_recursive($menus, $menu);
            }
        }
        //die(var_dump($menus));
        $this->view->setVars(
            array('menus' => $menus,
            ));

    }
}
