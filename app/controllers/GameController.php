<?php
namespace Gutshot\Controllers;

/**
 * Display the terms and conditions page.
 */
class GameController extends ControllerBase
{


    /**
     * Default action, shows the search form
     */
    public function indexAction()
    {
        $this->view->setTemplateBefore('private');
        $player = $this->auth->getPlayer();
        $params = array("Command"  => "AccountsSessionKey",
            "Player"   => $player);

        // Check the api password
        $api = $this->getDI()->getApi()->poker($params);
        if ($api -> Result == "Ok"){
            $src = $this->config->poker_api['poker_url'] . "/?LoginName=" . $player . "&amp;SessionKey=" . $api -> SessionKey;
            $this->view->setVar("src", $src);
        }
    }

    public function wideAction()
    {
        $this->view->setTemplateBefore('wide');
        $player = $this->auth->getPlayer();
        $params = array("Command"  => "AccountsSessionKey",
            "Player"   => $player);

        // Check the api password
        $api = $this->getDI()->getApi()->poker($params);
        if ($api -> Result == "Ok"){
            $src = $this->config->poker_api['poker_url'] . "/?LoginName=" . $player . "&amp;SessionKey=" . $api -> SessionKey;
            $this->view->setVar("src", $src);
        }
    }
}
