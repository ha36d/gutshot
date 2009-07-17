<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\TourneysForm;
use Gutshot\Models\Tourneys;

/**
 * Gutshot\Controllers\TourneysController
 * CRUD to manage tourneys
 */
class TourneysController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array();
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Tourneys', $this->request->getPost());
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $tourneys = Tourneys::find($parameters);

        $paginator = new Paginator(array(
            "data" => $tourneys,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for tourneys
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new TourneysForm();
    }


    /**
     * Creates a User
     */
    public function createAction()
    {
        $form = new TourneysForm;
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $tourney = new Tourneys();

                $post = array(
                    'name' => $this->request->getPost('name'),
                    'game' => $this->request->getPost('game'),
                    'shootout' => $this->request->getPost('shootout'),
                    'description' => $this->request->getPost('description'),
                    'auto' => $this->request->getPost('auto'),
                    'pw' => $this->request->getPost('pw'),
                    'private' => $this->request->getPost('private'),
                    'perm_register' => $this->request->getPost('perm_register'),
                    'perm_unregister' => $this->request->getPost('perm_unregister'),
                    'perm_observe' => $this->request->getPost('perm_observe'),
                    'perm_player_chat' => $this->request->getPost('perm_player_chat'),
                    'perm_observer_chat' => $this->request->getPost('perm_observer_chat'),
                    'suspend_chat_all_in' => $this->request->getPost('suspend_chat_all_in'),
                    'tables' => $this->request->getPost('tables'),
                    'seats' => $this->request->getPost('seats'),
                    'start_full' => $this->request->getPost('start_full'),
                    'start_min' => $this->request->getPost('start_min'),
                    'start_code' => $this->request->getPost('start_code'),
                    'start_time' => $this->request->getPost('start_time'),
                    'reg_period' => $this->request->getPost('reg_period'),
                    'late_reg_minutes' => $this->request->getPost('late_reg_minutes'),
                    'min_players' => $this->request->getPost('min_players'),
                    'recur_minutes' => $this->request->getPost('recur_minutes'),
                    'no_show_minutes' => $this->request->getPost('no_show_minutes'),
                    'buy_in' => $this->request->getPost('buy_in'),
                    'entry_fee' => $this->request->getPost('entry_fee'),
                    'prize_bonus' => $this->request->getPost('prize_bonus'),
                    'multiply_bonus' => $this->request->getPost('multiply_bonus'),
                    'chips' => $this->request->getPost('chips'),
                    'add_on_chips' => $this->request->getPost('add_on_chips'),
                    'turn_clock' => $this->request->getPost('turn_clock'),
                    'time_bank' => $this->request->getPost('time_bank'),
                    'bank_reset' => $this->request->getPost('bank_reset'),
                    'dis_protect' => $this->request->getPost('dis_protect'),
                    'level' => $this->request->getPost('level'),
                    'rebuy_levels' => $this->request->getPost('rebuy_levels'),
                    'threshold' => $this->request->getPost('threshold'),
                    'max_rebuys' => $this->request->getPost('max_rebuys'),
                    'rebuy_cost' => $this->request->getPost('rebuy_cost'),
                    'rebuy_fee' => $this->request->getPost('rebuy_fee'),
                    'break_time' => $this->request->getPost('break_time'),
                    'break_levels' => $this->request->getPost('break_levels'),
                    'stop_on_chop' => $this->request->getPost('stop_on_chop'),
                    'blinds' => $this->request->getPost('blinds'),
                    'payout' => $this->request->getPost('payout'),
                    'unreg_logout' => $this->request->getPost('unreg_logout'),
                    'usersId' => $this->auth->getId(),
                );

                $tourney->assign($post);

                if (!$tourney->save()) {
                    foreach ($tourney->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {

                    $params = array("Command" => "TournamentsAdd",
                        'Name' => $post['name'],
                        'Game' => $post['game'],
                        'Shootout' => $post['shootout'],
                        'Description' => $post['description'],
                        'Auto' => $post['auto'],
                        'PW' => $post['pw'],
                        'Private' => $post['private'],
                        'PermRegister' => $post['perm_register'],
                        'PermUnregister' => $post['perm_unregister'],
                        'PermObserve' => $post['perm_observe'],
                        'PermPlayerChat' => $post['perm_player_chat'],
                        'PermObserverChat' => $post['perm_observer_chat'],
                        'SuspendChatAllIn' => $post['suspend_chat_all_in'],
                        'Tables' => $post['tables'],
                        'Seats' => $post['seats'],
                        'StartFull' => $post['start_full'],
                        'StartMin' => $post['start_min'],
                        'StartCode' => $post['start_code'],
                        'StartTime' => $post['start_time'],
                        'RegPeriod' => $post['reg_period'],
                        'LateRegMinutes' => $post['late_reg_minutes'],
                        'MinPlayers' => $post['min_players'],
                        'RecurMinutes' => $post['recur_minutes'],
                        'NoShowMinutes' => $post['no_show_minutes'],
                        'BuyIn' => $post['buy_in'],
                        'EntryFee' => $post['entry_fee'],
                        'PrizeBonus' => $post['prize_bonus'],
                        'MultiplyBonus' => $post['multiply_bonus'],
                        'Chips' => $post['chips'],
                        'AddOnChips' => $post['add_on_chips'],
                        'TurnClock' => $post['turn_clock'],
                        'TimeBank' => $post['time_bank'],
                        'BankReset' => $post['bank_reset'],
                        'DisProtect' => $post['dis_protect'],
                        'Level' => $post['level'],
                        'RebuyLevels' => $post['rebuy_levels'],
                        'Threshold' => $post['threshold'],
                        'MaxRebuys' => $post['max_rebuys'],
                        'RebuyCost' => $post['rebuy_cost'],
                        'RebuyFee' => $post['rebuy_fee'],
                        'BreakTime' => $post['break_time'],
                        'BreakLevels' => $post['break_levels'],
                        'StopOnChop' => $post['stop_on_chop'],
                        'Blinds' => $post['blinds'],
                        'Payout' => $post['payout'],
                        'UnregLogout' => $post['unreg_logout'],
                    );
                    $api = $this->getDI()->getApi()->poker($params);
                    if ($api->Result == "Ok") {
                        $this->flash->success("Tourney was created successfully");
                    } else {
                        $this->flash->error("Tourney was not created");
                        $tourney->delete();
                    }
                }
                $this->dispatcher->forward(array(
                    'action' => 'list'
                ));
            }

        }
        $this->view->form = $form;
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }

        if ($this->request->isPost()) {

            $post = array(
                'name' => $this->request->getPost('name'),
                'game' => $this->request->getPost('game'),
                'shootout' => $this->request->getPost('shootout'),
                'description' => $this->request->getPost('description'),
                'auto' => $this->request->getPost('auto'),
                'pw' => $this->request->getPost('pw'),
                'private' => $this->request->getPost('private'),
                'perm_register' => $this->request->getPost('perm_register'),
                'perm_unregister' => $this->request->getPost('perm_unregister'),
                'perm_observe' => $this->request->getPost('perm_observe'),
                'perm_player_chat' => $this->request->getPost('perm_player_chat'),
                'perm_observer_chat' => $this->request->getPost('perm_observer_chat'),
                'suspend_chat_all_in' => $this->request->getPost('suspend_chat_all_in'),
                'tables' => $this->request->getPost('tables'),
                'seats' => $this->request->getPost('seats'),
                'start_full' => $this->request->getPost('start_full'),
                'start_min' => $this->request->getPost('start_min'),
                'start_code' => $this->request->getPost('start_code'),
                'start_time' => $this->request->getPost('start_time'),
                'reg_period' => $this->request->getPost('reg_period'),
                'late_reg_minutes' => $this->request->getPost('late_reg_minutes'),
                'min_players' => $this->request->getPost('min_players'),
                'recur_minutes' => $this->request->getPost('recur_minutes'),
                'no_show_minutes' => $this->request->getPost('no_show_minutes'),
                'buy_in' => $this->request->getPost('buy_in'),
                'entry_fee' => $this->request->getPost('entry_fee'),
                'prize_bonus' => $this->request->getPost('prize_bonus'),
                'multiply_bonus' => $this->request->getPost('multiply_bonus'),
                'chips' => $this->request->getPost('chips'),
                'add_on_chips' => $this->request->getPost('add_on_chips'),
                'turn_clock' => $this->request->getPost('turn_clock'),
                'time_bank' => $this->request->getPost('time_bank'),
                'bank_reset' => $this->request->getPost('bank_reset'),
                'dis_protect' => $this->request->getPost('dis_protect'),
                'level' => $this->request->getPost('level'),
                'rebuy_levels' => $this->request->getPost('rebuy_levels'),
                'threshold' => $this->request->getPost('threshold'),
                'max_rebuys' => $this->request->getPost('max_rebuys'),
                'rebuy_cost' => $this->request->getPost('rebuy_cost'),
                'rebuy_fee' => $this->request->getPost('rebuy_fee'),
                'break_time' => $this->request->getPost('break_time'),
                'break_levels' => $this->request->getPost('break_levels'),
                'stop_on_chop' => $this->request->getPost('stop_on_chop'),
                'blinds' => $this->request->getPost('blinds'),
                'payout' => $this->request->getPost('payout'),
                'unreg_logout' => $this->request->getPost('unreg_logout'),
                'usersId' => $this->auth->getId(),
            );

            $tourney->assign($post);

            $params = array("Command" => "TournamentsEdit",
                'Name' => $post['name'],
                'Game' => $post['game'],
                'Shootout' => $post['shootout'],
                'Description' => $post['description'],
                'Auto' => $post['auto'],
                'PW' => $post['pw'],
                'Private' => $post['private'],
                'PermRegister' => $post['perm_register'],
                'PermUnregister' => $post['perm_unregister'],
                'PermObserve' => $post['perm_observe'],
                'PermPlayerChat' => $post['perm_player_chat'],
                'PermObserverChat' => $post['perm_observer_chat'],
                'SuspendChatAllIn' => $post['suspend_chat_all_in'],
                'Tables' => $post['tables'],
                'Seats' => $post['seats'],
                'StartFull' => $post['start_full'],
                'StartMin' => $post['start_min'],
                'StartCode' => $post['start_code'],
                'StartTime' => $post['start_time'],
                'RegPeriod' => $post['reg_period'],
                'LateRegMinutes' => $post['late_reg_minutes'],
                'MinPlayers' => $post['min_players'],
                'RecurMinutes' => $post['recur_minutes'],
                'NoShowMinutes' => $post['no_show_minutes'],
                'BuyIn' => $post['buy_in'],
                'EntryFee' => $post['entry_fee'],
                'PrizeBonus' => $post['prize_bonus'],
                'MultiplyBonus' => $post['multiply_bonus'],
                'Chips' => $post['chips'],
                'AddOnChips' => $post['add_on_chips'],
                'TurnClock' => $post['turn_clock'],
                'TimeBank' => $post['time_bank'],
                'BankReset' => $post['bank_reset'],
                'DisProtect' => $post['dis_protect'],
                'Level' => $post['level'],
                'RebuyLevels' => $post['rebuy_levels'],
                'Threshold' => $post['threshold'],
                'MaxRebuys' => $post['max_rebuys'],
                'RebuyCost' => $post['rebuy_cost'],
                'RebuyFee' => $post['rebuy_fee'],
                'BreakTime' => $post['break_time'],
                'BreakLevels' => $post['break_levels'],
                'StopOnChop' => $post['stop_on_chop'],
                'Blinds' => $post['blinds'],
                'Payout' => $post['payout'],
                'UnregLogout' => $post['unreg_logout'],
            );
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                if (!$tourney->save()) {
                    foreach ($tourney->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $this->flash->success("Tourney was edited successfully");
                }
            } else {
                $this->flash->error($api->Error);
            }
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }

        $this->view->tourney = $tourney;

        $this->view->form = new TourneysForm($tourney, array(
            'edit' => true
        ));
    }

    /**
     * Deletes a User
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsDelete",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            if (!$tourney->delete()) {
                foreach ($tourney->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flash->success("Tourney was deleted");
            }
        } else {
            $this->flash->error($api->Error);
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function onlineAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsOnline",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'online',
                )
            );
            $this->flash->success("Tourney is online");
        } else {
            $this->flash->error($api->Error);
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }


    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function offlineAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsOffline",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'offline',
                )
            );
            $this->flash->success("Tourney is offline");
        } else {
            $this->flash->error($api->Error);
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function offlineNowAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }

        $params = array("Command" => "TournamentsOffline",
            "Name" => $tourney->name,
            "Now" => "Yes"
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'offline',
                )
            );
            $this->flash->success("Tourney is offline");
        } else {
            $this->flash->error("Tourney has players and can not be offline.");
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function removeNoShowsAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsRemoveNoShows",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $this->flash->success("Tourney No Show Action is done");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    public function pauseAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsPause",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'paused',
                )
            );
            $this->flash->success("Tourney is paused");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function resumeAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsResume",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'online',
                )
            );
            $this->flash->success("Tourney is resumed");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Tourney
     *
     * @param int $id
     */
    public function startAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "TournamentsStart",
            "Name" => $tourney->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $tourney->update(
                array(
                    'status' => 'online',
                )
            );
            $this->flash->success("Tourney is started");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Register for a Tourney
     *
     */
    public function registerAction()
    {
        $this->view->disable();
        $name = $this->request->getPost('name');
        $params = array("Command" => "TournamentsRegister",
            "Name" => $name,
            "Player" => $this->auth->getPlayer(),
        );
        $api = $this->getDI()->getApi()->poker($params);
        $this->response->redirect('index/index');
    }

    /**
     * Unregister for a Tourney
     *
     */
    public function unregisterAction()
    {
        $this->view->disable();
        $name = $this->request->getPost('name');
        $params = array("Command" => "TournamentsUnregister",
            "Name" => $name,
            "Player" => $this->auth->getPlayer(),
        );
        $api = $this->getDI()->getApi()->poker($params);
        $this->response->redirect('index/index');
    }

    public function messageAction($id)
    {
        $tourney = Tourneys::findFirstById($id);
        if (!$tourney) {
            $this->flash->error("Tourney was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        if ($this->request->isPost()) {
            $message = $this->request->getPost('message');
            $params = array("Command" => "TournamentsMessage",
                'Name' => $tourney->name,
                'Message' => $message,
            );
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                $this->flash->success("Message has been sent successfully");
            } else {
                $this->flash->error($api->Error);
            }
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $this->view->tourney = $tourney;
    }

}
