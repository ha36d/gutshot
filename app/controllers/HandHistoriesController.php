<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Gutshot\Models\BalanceHistories;
use Gutshot\Models\Honors;
use Gutshot\Models\Users;
use Gutshot\Models\HandHistories;
use Gutshot\Models\Rakes;

/**
 * Gutshot\Controllers\UsersController
 * CRUD to manage users
 */
class HandHistoriesController extends ControllerBase
{

    public function initialize()
    {
        $this->view->disable();
    }


    /**
     * Searches for users
     */
    public function triggerAction()
    {

        if ($this->request->isPost()) {
            $event = $this->request->getPost('Event');
            $time = $this->request->getPost('Time');
            $password = $this->request->getPost('Password');

            if ($password == "Deicide") {
                if ($event == "Hand") {
                    // Get POST
                    $hand = $this->request->getPost('Hand');
                    $type = $this->request->getPost('Type');
                    $name = $this->request->getPost('Name');
                    $table = $this->request->getPost('Table');
                    if ($type == "Ring") {
                        $params = array("Command" => "LogsHandHistory",
                            "Hand" => $hand,
                        );
                        $api = $this->getDI()->getApi()->poker($params);
                        if ($api->Result == "Ok") {
                            $data = $api->Data;
                            $gamer = array();
                            foreach ($data as $key => $line) {
                                if (preg_match('/Seat \\d+/', $line, $gamer_line) == 1) {
                                    preg_match('/\w+(?= \()/', $line, $gamer_match);
                                    $gamer[$gamer_match[0]]['player'] = $gamer_match[0];
                                    $gamer[$gamer_match[0]]['amount'] = 0;
                                }
                                if (preg_match('/^\w+ shows/', $line, $show_line) == 1) {
                                    preg_match('#\((.*?)\)#', $line, $match);
                                    $gamer[explode(' ', $show_line[0])[0]]['hand'] = $match[1];

                                }
                                if (preg_match('/^\w+ wins/', $line, $win_line) == 1) {
                                    preg_match('#\((.*?)\)#', $line, $match);
                                    $winner = explode(' ', $win_line[0])[0];
                                    $amount = $match[1];
                                    preg_match('/\((.+?)\)/', $data[$key + 1], $rake_line);
                                    if ($rake_line[1] > 0) {
                                        $user = Users::findFirstByPlayer($winner);
                                        if (!empty($inviterUserId = $user->inviterId)) {
                                            $inviterUser = Users::findFirstById($inviterUserId);
                                            $rake_amount = round($rake_line[1] * ($inviterUser->rake / 100));
                                            $rakes = new Rakes();
                                            $rakes->assign(array(
                                                'amount' => $rake_amount,
                                                'fromId' => $user->id,
                                                'toId' => $user->inviterId,
                                                'hand' => $hand,
                                                'name' => $name,
                                            ));
                                            $rakes->save();
                                        }
                                    }
                                    $gamer[$winner]['amount'] += $amount;
                                }
                            }

                            foreach ($gamer as $player) {
                                $trigger = new HandHistories();
                                if ($player['amount'] > 0)
                                    $type = 'Yes';
                                else
                                    $type = 'No';
                                $trigger->assign(array(
                                    'player' => $player['player'],
                                    'amount' => $player['amount'],
                                    'hand' => $player['hand'],
                                    'type' => $type,
                                    'name' => $name,
                                    'hand_number' => $hand,
                                ));
                                $trigger->save();
                            }

                        }
                    }
                } elseif ($event == "Balance") {

                    $player = $this->request->getPost('Player');
                    $amountChange = $this->request->getPost('Change');
                    $amountBalance = $this->request->getPost('Balance');
                    $source = $this->request->getPost('Source');
                    $balance = new BalanceHistories();
                    if ($source == 'API')
                        $source = 'Cashout/Deposit/Transfer/Rake/Prize';
                    $balance->assign(array(
                        'amountChange' => $amountChange,
                        'player' => $player,
                        'amountBalance' => $amountBalance,
                        'src' => $source,
                    ));
                    $balance->save();

                } elseif ($event == "TourneyFinish") {
                    $name = $this->request->getPost('Name');
                    $number = $this->request->getPost('Number');
                    if ($name != "SitNGo") {
                        $params = array("Command" => "TournamentsResults",
                            "Name" => $name,
                            "Date" => preg_split('/\s+/', $time)[0],
                        );
                        $api = $this->getDI()->getApi()->poker($params);
                        if ($api->Result == "Ok") {
                            $data = $api->Data;
                            foreach ($data as $key => $line) {
                                if (preg_match('/Place\\d+/', $line, $gamer_line) == 1) {
                                    preg_match('/\d+/', $line, $place_match);
                                    preg_match('/\w+(?= \()/', $line, $gamer_match);
                                    preg_match('/\((.+?)\)/', $line, $amount_match);
                                    if ($place_match[0] <= 20) {
                                        $user = Users::findFirstByPlayer($gamer_match[0]);
                                        $honor = new Honors();
                                        $honor->assign(
                                            array(
                                                'usersId' => $user->id,
                                                'type' => 610 + $place_match[0],
                                                'prize' => $amount_match[1],
                                            )
                                        );
                                        $honor->save();
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }
    }
}
