<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\PrivateRingsForm;
use Gutshot\Forms\RingsForm;
use Gutshot\Models\Rings;

/**
 * Gutshot\Controllers\RingsController
 * CRUD to manage rings
 */
class RingsController extends ControllerBase
{

    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Default action, shows the search form
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new RingsForm();
    }

    /**
     * Searches for rings
     */
    public function indexAction()
    {
        $form = new PrivateRingsForm(null);
        $parameters = array(
            "conditions" => "usersId = '" . $this->auth->getId() . "' AND private = 'Yes'",
        );
        $rings = Rings::find($parameters);
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message);
                }
            } else {
                if (count($rings) == 0) {
                    $ring = new Rings();

                    switch ($plan = $this->request->getPost('plan', 'int')) {
                        case 1:
                            $minimum_buy_in = 40000;
                            $maximum_buy_in = 200000;
                            $default_buy_in = 80000;
                            $small_blind = 1000;
                            $big_blind = 2000;
                            break;
                        case 2:
                            $minimum_buy_in = 200000;
                            $maximum_buy_in = 1000000;
                            $default_buy_in = 400000;
                            $small_blind = 5000;
                            $big_blind = 10000;
                            break;
                        case 3:
                            $minimum_buy_in = 1000000;
                            $maximum_buy_in = 5000000;
                            $default_buy_in = 2000000;
                            $small_blind = 25000;
                            $big_blind = 50000;
                            break;
                        default:
                            $minimum_buy_in = 40000;
                            $maximum_buy_in = 200000;
                            $default_buy_in = 80000;
                            $small_blind = 1000;
                            $big_blind = 2000;
                    }
                    switch ($speed = $this->request->getPost('speed', 'int')) {
                        case 1:
                            $turn_clock = 30;
                            $time_bank = 45;
                            $sitout_minutes = 10;
                            break;
                        case 2:
                            $turn_clock = 15;
                            $time_bank = 25;
                            $sitout_minutes = 5;
                            break;
                        default:
                            $turn_clock = 30;
                            $time_bank = 60;
                            $sitout_minutes = 10;
                            break;
                    }
                    $player = $this->auth->getPlayer();
                    $pw = $this->request->getPost('pw');
                    $game = $this->request->getPost('game');
                    $seats = $this->request->getPost('seats', 'int');
                    $ring->assign(array(
                        'name' => "Private Ring " . $player,
                        'pw' => $pw,
                        'seats' => $seats,
                        'description' => "Private Ring",
                        'game' => $game,
                        'private' => 'Yes',
                        'minimum_buy_in' => $minimum_buy_in,
                        'maximum_buy_in' => $maximum_buy_in,
                        'default_buy_in' => $default_buy_in,
                        'plan' => $plan,
                        'rake' => 2,
                        'rake_every' => 100,
                        'rake_max' => 20000,
                        'turn_clock' => $turn_clock,
                        'time_bank' => $time_bank,
                        'small_blind' => $small_blind,
                        'big_blind' => $big_blind,
                        'rathole_minutes' => 0,
                        'sitout_minutes' => $sitout_minutes,
                        'sitout_relaxed' => 'No',
                        'speed' => $speed,
                        'status' => 'private',
                        'usersId' => $this->auth->getId(),
                    ));

                    if (!$ring->save()) {
                        foreach ($ring->getMessages() as $error) {
                            $this->flashSession->error($error);
                        }
                    } else {
                        $this->flashSession->success("The private ring request has been created.");
                    }
                    $this->response->redirect("rings/index");
                } else {
                    $this->flashSession->error('Each User can have only 1 private ring');
                }
            }
        }
        $this->view->page = $rings;
        $this->view->form = $form;
    }

    /**
     * List all rings
     */
    public function listAction()
    {
        $numberPage = 1;
        $parameters = array('order' => 'createdAt DESC');
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Rings', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }
        $rings = Rings::find($parameters);
        $paginator = new Paginator(array(
            "data" => $rings,
            "limit" => 25,
            "page" => $numberPage
        ));
        $this->view->page = $paginator->getPaginate();
    }


    /**
     * Create Action
     */

    public function createAction()
    {
        if ($this->request->isPost()) {
            $ring = new Rings();
            $post = array(
                'name' => $this->request->getPost('name'),
                'game' => $this->request->getPost('game'),
                'description' => $this->request->getPost('description'),
                'auto' => $this->request->getPost('auto'),
                'pw' => $this->request->getPost('pw'),
                'private' => $this->request->getPost('private'),
                'perm_play' => $this->request->getPost('perm_play'),
                'perm_observe' => $this->request->getPost('perm_observe'),
                'perm_player_chat' => $this->request->getPost('perm_player_chat'),
                'perm_observer_chat' => $this->request->getPost('perm_observer_chat'),
                'suspend_chat_all_in' => $this->request->getPost('suspend_chat_all_in'),
                'seats' => $this->request->getPost('seats'),
                'smallest_chip' => $this->request->getPost('smallest_chip'),
                'minimum_buy_in' => $this->request->getPost('minimum_buy_in'),
                'maximum_buy_in' => $this->request->getPost('maximum_buy_in'),
                'default_buy_in' => $this->request->getPost('default_buy_in'),
                'rake' => $this->request->getPost('rake'),
                'rake_every' => $this->request->getPost('rake_every'),
                'rake_max' => $this->request->getPost('rake_max'),
                'turn_clock' => $this->request->getPost('turn_clock'),
                'time_bank' => $this->request->getPost('time_bank'),
                'bank_reset' => $this->request->getPost('bank_reset'),
                'dis_protect' => $this->request->getPost('dis_protect'),
                'small_blind' => $this->request->getPost('small_blind'),
                'big_blind' => $this->request->getPost('big_blind'),
                'dupe_ips' => $this->request->getPost('dupe_ips'),
                'rathole_minutes' => $this->request->getPost('rathole_minutes'),
                'sitout_minutes' => $this->request->getPost('sitout_minutes'),
                'sitout_relaxed' => $this->request->getPost('sitout_relaxed'),
                'usersId' => $this->auth->getId(),
            );

            $ring->assign($post);

            if (!$ring->save()) {
                foreach ($ring->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $params = array("Command" => "RingGamesAdd",
                    'Name' => $post['name'],
                    'Game' => $post['game'],
                    'Description' => $post['description'],
                    'Auto' => $post['auto'],
                    'PW' => $post['pw'],
                    'Private' => $post['private'],
                    'PermPlay' => $post['perm_play'],
                    'PermObserve' => $post['perm_observe'],
                    'PermPlayerChat' => $post['perm_player_chat'],
                    'PermObserverChat' => $post['perm_observer_chat'],
                    'SuspendChatAllIn' => $post['suspend_chat_all_in'],
                    'Seats' => $post['seats'],
                    'SmallestChip' => $post['smallest_chip'],
                    'BuyInMin' => $post['minimum_buy_in'],
                    'BuyInMax' => $post['maximum_buy_in'],
                    'BuyInDef' => $post['default_buy_in'],
                    'Rake' => $post['rake'],
                    'RakeEvery' => $post['rake_every'],
                    'RakeMax' => $post['rake_max'],
                    'TimeBank' => $post['time_bank'],
                    'BankReset' => $post['bank_reset'],
                    'DisProtect' => $post['dis_protect'],
                    'SmallBlind' => $post['small_blind'],
                    'BigBlind' => $post['big_blind'],
                    'DupeIPs' => $post['dupe_ips'],
                    'RatholeMinutes' => $post['rathole_minutes'],
                    'SitoutMinutes' => $post['sitout_minutes'],
                    'SitoutRelaxed' => $post['sitout_relaxed'],
                );
                $api = $this->getDI()->getApi()->poker($params);
                if ($api->Result == "Ok") {
                    $this->flash->success("Ring was created successfully");
                    $this->response->redirect('rings/list');
                } else {
                    $this->flash->error($api->Error);
                    $ring->delete();
                }
            }

        }

        $this->view->form = new RingsForm(null);
    }

    /**
     * Saves the user from the 'edit' action
     */
    public function editAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $old_name = $ring->name;
        if ($this->request->isPost()) {
            $post = array(
                'name' => $this->request->getPost('name'),
                'game' => $this->request->getPost('game'),
                'description' => $this->request->getPost('description'),
                'auto' => $this->request->getPost('auto'),
                'pw' => $this->request->getPost('pw'),
                'private' => $this->request->getPost('private'),
                'perm_play' => $this->request->getPost('perm_play'),
                'perm_observe' => $this->request->getPost('perm_observe'),
                'perm_player_chat' => $this->request->getPost('perm_player_chat'),
                'perm_observer_chat' => $this->request->getPost('perm_observer_chat'),
                'suspend_chat_all_in' => $this->request->getPost('suspend_chat_all_in'),
                'seats' => $this->request->getPost('seats'),
                'smallest_chip' => $this->request->getPost('smallest_chip'),
                'minimum_buy_in' => $this->request->getPost('minimum_buy_in'),
                'maximum_buy_in' => $this->request->getPost('maximum_buy_in'),
                'default_buy_in' => $this->request->getPost('default_buy_in'),
                'rake' => $this->request->getPost('rake'),
                'rake_every' => $this->request->getPost('rake_every'),
                'rake_max' => $this->request->getPost('rake_max'),
                'turn_clock' => $this->request->getPost('turn_clock'),
                'time_bank' => $this->request->getPost('time_bank'),
                'bank_reset' => $this->request->getPost('bank_reset'),
                'dis_protect' => $this->request->getPost('dis_protect'),
                'small_blind' => $this->request->getPost('small_blind'),
                'big_blind' => $this->request->getPost('big_blind'),
                'dupe_ips' => $this->request->getPost('dupe_ips'),
                'rathole_minutes' => $this->request->getPost('rathole_minutes'),
                'sitout_minutes' => $this->request->getPost('sitout_minutes'),
                'sitout_relaxed' => $this->request->getPost('sitout_relaxed'),
                //'usersId' => $this->auth->getId(),
            );

            $ring->assign($post);

            if ($ring->status != 'private') {
                $params = array("Command" => "RingGamesEdit",
                    'Name' => $old_name,
                    'Game' => $post['game'],
                    'Description' => $post['description'],
                    'Auto' => $post['auto'],
                    'PW' => $post['pw'],
                    'Private' => $post['private'],
                    'PermPlay' => $post['perm_play'],
                    'PermObserve' => $post['perm_observe'],
                    'PermPlayerChat' => $post['perm_player_chat'],
                    'PermObserverChat' => $post['perm_observer_chat'],
                    'SuspendChatAllIn' => $post['suspend_chat_all_in'],
                    'Seats' => $post['seats'],
                    'SmallestChip' => $post['smallest_chip'],
                    'BuyInMin' => $post['minimum_buy_in'],
                    'BuyInMax' => $post['maximum_buy_in'],
                    'BuyInDef' => $post['default_buy_in'],
                    'Rake' => $post['rake'],
                    'RakeEvery' => $post['rake_every'],
                    'RakeMax' => $post['rake_max'],
                    'TimeBank' => $post['time_bank'],
                    'BankReset' => $post['bank_reset'],
                    'DisProtect' => $post['dis_protect'],
                    'SmallBlind' => $post['small_blind'],
                    'BigBlind' => $post['big_blind'],
                    'DupeIPs' => $post['dupe_ips'],
                    'RatholeMinutes' => $post['rathole_minutes'],
                    'SitoutMinutes' => $post['sitout_minutes'],
                    'SitoutRelaxed' => $post['sitout_relaxed'],
                );
                $api = $this->getDI()->getApi()->poker($params);
                if ($api->Result == "Ok") {
                    if (!$ring->save()) {
                        foreach ($ring->getMessages() as $error) {
                            $this->flash->error($error);
                        }
                    } else {
                        $this->flash->success("Ring was edited successfully");
                    }
                } else {
                    $this->flash->error($api->Error);
                }
            } else {
                if (!$ring->save()) {
                    foreach ($ring->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    $this->flash->success("Ring was edited successfully");
                }
            }
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $this->view->ring = $ring;
        $this->view->form = new RingsForm($ring, array(
            'edit' => true
        ));
    }

    /**
     * Deletes a Ring
     *
     * @param int $id
     */
    public function deleteAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "RingGamesDelete",
            "Name" => $ring->name,
        );
        $api = $this->getDI()->getApi()->poker($params);


        if ($api->Result == "Ok") {
            if (!$ring->delete()) {
                foreach ($ring->getMessages() as $error) {
                    $this->flash->error($error);
                }
            } else {
                $this->flash->success("Ring was deleted");
            }
        } else {
            $this->flash->error($api->Error);
        }
        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Ring
     *
     * @param int $id
     */
    public function onlineAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "RingGamesOnline",
            "Name" => $ring->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {

            $ring->update(
                array(
                    'status' => 'online',
                )
            );
            $this->flash->success("Ring is online");
        } else {
            $this->flash->error($api->Error);
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }


    /**
     * Offline a Ring
     *
     * @param int $id
     */
    public
    function offlineAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "RingGamesPlaying",
            "Name" => $ring->name,
        );
        $api = $this->getDI()->getApi()->poker($params);

        if ($api->Result == "Ok" && $api->Count == 0) {
            $params = array("Command" => "RingGamesOffline",
                "Name" => $ring->name,
            );
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                $ring->update(
                    array(
                        'status' => 'offline',
                    )
                );
                $this->flash->success("Ring is offline");
            } else {
                $this->flash->error($api->Error);
            }
        } else {
            $this->flash->error("Ring has players and can not be offline.");
        }

        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Ring
     *
     * @param int $id
     */
    public function acceptAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        if ($ring->status == 'private') {
            $params = array("Command" => "RingGamesAdd",
                "Name" => $ring->name,
                "Description" => $ring->description,
                "Auto" => $ring->auto_online,
                "Game" => $ring->game,
                "PW" => $ring->pw,
                "private" => $ring->private,
                "Seats" => $ring->seats,
                "SmallestChip" => $ring->smallest_chip,
                "BuyInMin" => $ring->minimum_buy_in,
                "BuyInMax" => $ring->maximum_buy_in,
                "BuyInDef" => $ring->default_buy_in,
                "Rake" => $ring->rake,
                "RakeEvery" => $ring->rake_every,
                "RakeMax" => $ring->rake_max,
                "TurnClock" => $ring->turn_clock,
                "TimeBank" => $ring->time_bank,
                "DisProtect" => $ring->dis_protect,
                "SmallBlind" => $ring->small_blind,
                "BigBlind" => $ring->big_blind,
                "DupeIPs" => $ring->dupe_ips,
                "RatholeMinutes" => $ring->rathole_minutes,
                "SitoutMinutes" => $ring->sitout_minutes,
                "SitoutRelaxed" => $ring->sitout_relaxed,
            );
            $api = $this->getDI()->getApi()->poker($params);
            if ($api->Result == "Ok") {
                $ring->update(
                    array(
                        'status' => 'offline',
                    )
                );
                $this->flash->success("Ring was created successfully");
            } else {
                $this->flash->error("Ring was not created. " . $api->Error);
                $ring->delete();
            }
        } else {
            $this->flash->error("Ring was not created.");
        }
        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }


    /**
     * Online a Ring
     *
     * @param int $id
     */
    public function rejectAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        if ($ring->status == 'private') {
            if ($ring->delete()) {
                $this->flash->success("Ring was removed successfully");
            } else {
                $this->flash->error("Ring was not removed.");
            }
        } else {
            $this->flash->error("Ring was not found.");
        }
        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Deletes a Ring in User Mode
     *
     * @param int $id
     */
    public function cancelAction()
    {
        $this->view->disable();
        $id = $this->request->getPost('id');
        $parameters = array(
            "conditions" => "id = " . $id . " AND usersId = " . $this->auth->getId(),
        );
        $ring = Rings::findFirst($parameters);

        if ($ring && $ring->usersId == $this->auth->getId() && $ring->status == 'private') {
            if (!$ring->delete()) {
                foreach ($ring->getMessages() as $error) {
                    $this->flashSession->error($error);
                }
            } else {
                $this->flashSession->success("Ring was successfully deleted");
            }
        } else {
            $this->flashSession->error("Ring was not found");
        }
        $this->response->redirect('rings/index');
    }

    public function pauseAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "RingGamesPause",
            "Name" => $ring->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $ring->update(
                array(
                    'status' => 'paused',
                )
            );
            $this->flash->success("Ring is paused");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    /**
     * Online a Ring
     *
     * @param int $id
     */
    public function resumeAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        $params = array("Command" => "RingGamesResume",
            "Name" => $ring->name,
        );
        $api = $this->getDI()->getApi()->poker($params);
        if ($api->Result == "Ok") {
            $ring->update(
                array(
                    'status' => 'online',
                )
            );
            $this->flash->success("Ring is resumed");
        } else {
            $this->flash->error($api->Error);
        }


        $this->dispatcher->forward(array(
            'action' => 'list'
        ));
    }

    public function messageAction($id)
    {
        $ring = Rings::findFirstById($id);
        if (!$ring) {
            $this->flash->error("Ring was not found");
            $this->dispatcher->forward(array(
                'action' => 'list'
            ));
        }
        if ($this->request->isPost()) {
            $message = $this->request->getPost('message');
            $params = array("Command" => "RingGamesMessage",
                'Name' => $ring->name,
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
        $this->view->ring = $ring;
    }
}
