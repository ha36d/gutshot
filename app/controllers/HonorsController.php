<?php
namespace Gutshot\Controllers;

use Phalcon\Tag;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Gutshot\Forms\HonorsForm;
use Gutshot\Models\HandHistories;
use Gutshot\Models\Honors;
use Gutshot\Models\Users;

/**
 * Gutshot\Controllers\ProfilesController
 * CRUD to manage groups
 */
class HonorsController extends ControllerBase
{

    function sign($n)
    {
        return ($n > 0) - ($n < 0);
    }

    /**
     * Default action. Set the private (authenticated) layout (layouts/private.volt)
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Search for honor
     */
    public function searchAction()
    {
        $this->persistent->conditions = null;
        $this->view->form = new HonorsForm();
    }

    /**
     * List the honors
     */
    public function listAction()
    {
        $parameters = array('order' => 'createdAt DESC');
        $numberPage = 1;
        if ($this->request->isPost()) {
            $createdAtFrom = empty($this->request->getPost('createdAtFrom')) ? '1' : $this->request->getPost('createdAtFrom');
            $createdAtTo = empty($this->request->getPost('createdAtTo')) ? date('d-m-Y H:i:s') : $this->request->getPost('createdAtTo');
            $query = Criteria::fromInput($this->di, 'Gutshot\Models\Honors', $this->request->getPost())
                ->betweenWhere('createdAt', strtotime($createdAtFrom), strtotime($createdAtTo))
                ->orderBy('createdAt DESC');
            $parameters = $this->persistent->searchParams = $query->getParams();
        } elseif (!empty($numberPage = $this->request->getQuery("page", "int"))) {
            if ($this->persistent->searchParams) {
                $parameters = $this->persistent->searchParams;
            }
        } else {
            $this->persistent->searchParams = null;
        }

        $honors = Honors::find($parameters);

        $paginator = new Paginator(array(
            "data" => $honors,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Creates a new Honor
     */
    public function giveAction()
    {

        $form = new HonorsForm();
        if ($this->request->isPost()) {

            if (!$form->isValid($this->request->getPost())) {

                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $honor = new Honors();

                $amount = $this->request->getPost('prize');
                $usersId = $this->request->getPost('usersId');
                $user = Users::findFirstById($usersId);
                $type = $this->request->getPost('type');
                $place = $this->request->getPost('place');
                $comment = $this->request->getPost('comment');
                $honor->assign(array(
                    'prize' => $amount,
                    'usersId' => $usersId,
                    'type' => $type * 100 + $place,
                    'comment' => $comment,
                ));
                if (!$honor->save()) {
                    foreach ($honor->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    if ($amount > 0) {
                        $params = array("Command" => "AccountsIncBalance",
                            "Player" => $user->player,
                            "Amount" => $amount,
                        );
                        $api = $this->getDI()->getApi()->poker($params);
                        if ($api->Result == "Ok") {
                            $this->flash->success("Honor added to account " . $user->player . "successfully");
                            $this->dispatcher->forward(array(
                                "action" => "list"
                            ));
                        } else {
                            $this->flash->error($api->Error);
                            $honor->delete();
                        }
                    } else {
                        $this->flash->success("Honor added to account " . $user->player . " successfully");
                        $this->dispatcher->forward(array(
                            "action" => "list"
                        ));
                    }
                }
            }

        }
        $this->view->form = $form;
    }

    public function wonAction()
    {
        if ($this->request->isPost()) {
            $hands = $this->request->getPost('hands');
            if (empty($date = $this->request->getPost('date')))
                $dateCondition = "";
            else
                $dateCondition = " AND createdAt >= " . strtotime($date);

            $most_hands_winners = HandHistories::count(
                array(
                    "group" => "player",
                    "order" => "rowcount DESC",
                    "type = 'Yes' " . $dateCondition,
                )
            );
            $winners = array();
            foreach ($most_hands_winners as $most_hands_winner) {
                if ($most_hands_winner->rowcount >= $hands) {
                    $winners[] = $most_hands_winner;
                }
            }
            // Get User

            $this->view->winners = $winners;
        }
    }

    public function playedAction()
    {
        if ($this->request->isPost()) {
            $hands = $this->request->getPost('hands');
            if (empty($date = $this->request->getPost('date')))
                $dateCondition = "";
            else
                $dateCondition = " AND createdAt >= " . strtotime($date);

            $most_hands_played = HandHistories::count(
                array(
                    "group" => "player",
                    "order" => "rowcount DESC",
                    $dateCondition,
                )
            );
            $winners = array();
            foreach ($most_hands_played as $most_hand_played) {
                if ($most_hand_played->rowcount >= $hands) {
                    $winners[] = $most_hand_played;
                }
            }
            // Get User

            $this->view->winners = $winners;
        }
    }

    public function levelAction()
    {
        if ($this->request->isPost()) {
            $level = !empty($this->request->getPost('level')) ? $this->request->getPost('level') : 0;
            $xp = !empty($this->request->getPost('xp')) ? $this->request->getPost('xp') : 0;

            if ($xp == 0 && $level == 0)
                $winners = Users::find(
                    array(
                        "order" => "xp DESC",
                        "conditions" => "active = 'Y'",
                    )
                );
            else {
                $winners = Users::find(
                    array(
                        "order" => "xp DESC",
                        "conditions" => "active = 'Y' AND level >= " . $level . " AND xp >= " . $xp,
                    )
                );
            }
            $this->view->winners = $winners;
        }
    }

    public function prizesAction()
    {
        $prize = array();
        $prizes = array();
        $honorsGiven = array();
        $usersId = $this->auth->getId();
        $honors = Honors::find(
            array(
                "conditions" => "type >= 800 AND usersId = " . $usersId,
            )
        );
        $user = Users::findFirstById($usersId);
        $level = $user->level;
        foreach ($honors as $honor) {
            $honorsGiven[] = $honor->type;
        }
        for ($i = 1; $i <= $level; $i++) {
            $curLevel = 810 + $i;
            if (in_array($curLevel, $honorsGiven)) {
                $prize['done'] = 'no';
            } else
                $prize['done'] = 'yes';
            $prize['type'] = $curLevel;
            $prizes[] = $prize;
        }
        $this->view->prizes = $prizes;
        $this->view->honors = $honors;
    }

    public function doneAction()
    {
        if ($this->request->isPost()) {
            $champs_value = array(
                '811' => '300',
                '812' => '500',
                '813' => '800',
                '814' => '1200',
                '815' => '1700',
                '816' => '2500',
                '817' => '5000',
                '818' => '8000',
                '819' => '13000',
                '820' => '20000',
                '821' => '32000',
                '822' => '55000',
                '823' => '90000',
                '824' => '150000',
                '825' => '240000',
                '826' => '380000',
                '827' => '700000',
                '828' => '1100000',
                '829' => '1800000',
                '830' => '2800000',
                '831' => '4600000',
                '832' => '8000000',
                '833' => '15000000',
                '834' => '25000000',
                '835' => '40000000'
            );
            $id = $this->request->getPost('id');
            $usersId = $this->auth->getId();
            $parameters = array(
                "conditions" => "type = '" . $id . "' AND usersId = '" . $usersId . "'",
            );
            $honors = Honors::findFirst($parameters);

            if (!$honors) {
                $honor = new Honors();
                $amount = $champs_value[$id];
                $user = Users::findFirstById($usersId);
                $type = $id;
                $comment = 'User Got the prize';
                $honor->assign(array(
                    'prize' => $amount,
                    'usersId' => $usersId,
                    'type' => $type,
                    'comment' => $comment,
                ));
                if (!$honor->save()) {
                    foreach ($honor->getMessages() as $error) {
                        $this->flash->error($error);
                    }
                } else {
                    if ($amount > 0) {
                        $params = array("Command" => "AccountsIncBalance",
                            "Player" => $user->player,
                            "Amount" => $amount,
                        );
                        $api = $this->getDI()->getApi()->poker($params);
                        if ($api->Result == "Ok") {
                            $this->flashSession->success($champs_value[$id] . " chips added to balance successfully");
                        } else {
                            $this->flashSession->error($api->Error);
                            $honor->delete();
                        }
                    } else {
                        $this->flash->success("Honor added to account " . $user->player . " successfully");
                    }
                }
            } else {
                $this->flashSession->error("You have got the prize earlier.");
            }
            $this->response->redirect('honors/prizes');
        }
    }

    public function championsAction()
    {
        if ($this->request->isPost()) {
            if (!empty($date = $this->request->getPost('date'))) {
                if ($date == '-1')
                    $duration = "createdAt >= " . strtotime(($date + 1) . " saturday");
                else
                    $duration = "createdAt >= " . strtotime(($date + 1) . " saturday") . " AND createdAt <= " . strtotime(($date + 2) . " saturday");
            } else
                $duration = "createdAt > 1";

            $most_hands_played = HandHistories::count(
                array(
                    "group" => "player",
                    "order" => "rowcount DESC",
                    $duration,
                )
            );

            $most_hands_winners = HandHistories::count(
                array(
                    "group" => "player",
                    "order" => "rowcount DESC",
                    "type = 'Yes' AND " . $duration,
                )
            );

            $most_pot_winners = HandHistories::find(
                array(
                    "conditions" => "type = 'Yes' AND " . $duration,
                    "order" => "amount DESC",
                )
            );

            $cheap_leaders = HandHistories::sum(
                array(
                    "column" => "amount",
                    "group" => "player",
                    "order" => "sumatory DESC",
                    "conditions" => "type = 'Yes' AND " . $duration,
                )
            );

            $best_hand_winners = HandHistories::find(
                array(
                    "columns" => "player, hand, amount",
                    "conditions" => "type = 'Yes' AND hand_value > 0 AND " . $duration,
                    "order" => "hand_value DESC",
                )
            );
            // Get User
            $this->view->setVars(
                array('champ_most_hands_played' => $most_hands_played,
                    'champ_most_hands_winners' => $most_hands_winners,
                    'champ_most_pot_winners' => $most_pot_winners,
                    'champ_cheap_leaders' => $cheap_leaders,
                    'champ_best_hand_winners' => $best_hand_winners,
                ));;
        }
    }

    public function computeAction()
    {
        $most_hands_played = HandHistories::count(
            array(
                "group" => "player",
                "order" => "rowcount DESC",
            )
        );

        $most_hands_winners = HandHistories::count(
            array(
                "group" => "player",
                "order" => "rowcount DESC",
                "type = 'Yes'",
            )
        );

        $cheap_leaders = HandHistories::sum(
            array(
                "column" => "amount",
                "group" => "player",
                "order" => "sumatory DESC",
                "conditions" => "type = 'Yes'",
            )
        );

        $champs = Honors::find();
        $users = Users::find();

        $champs_value = array(
            '111' => '15000',
            '112' => '10000',
            '113' => '7000',
            '114' => '5000',
            '115' => '4000',
            '116' => '3500',
            '117' => '3000',
            '118' => '2500',
            '119' => '2000',
            '120' => '1500',
            '121' => '1250',
            '122' => '1000',
            '123' => '750',
            '124' => '750',
            '125' => '750',
            '126' => '500',
            '127' => '500',
            '128' => '500',
            '129' => '250',
            '130' => '250',
            '211' => '5000',
            '212' => '3000',
            '213' => '2000',
            '214' => '1500',
            '215' => '1000',
            '216' => '1000',
            '217' => '750',
            '218' => '750',
            '219' => '750',
            '220' => '750',
            '221' => '500',
            '222' => '500',
            '223' => '500',
            '224' => '500',
            '225' => '250',
            '226' => '250',
            '227' => '250',
            '228' => '250',
            '229' => '250',
            '230' => '250',
            '311' => '10000',
            '312' => '7000',
            '313' => '5000',
            '314' => '3500',
            '315' => '2500',
            '316' => '2000',
            '317' => '1750',
            '318' => '1500',
            '319' => '1250',
            '320' => '1000',
            '321' => '750',
            '322' => '750',
            '323' => '500',
            '324' => '500',
            '325' => '500',
            '326' => '500',
            '327' => '250',
            '328' => '250',
            '329' => '250',
            '330' => '250',
            '411' => '15000',
            '412' => '10000',
            '413' => '7000',
            '414' => '5000',
            '415' => '4000',
            '416' => '3500',
            '417' => '3000',
            '418' => '2500',
            '419' => '2000',
            '420' => '1500',
            '421' => '1250',
            '422' => '1000',
            '423' => '750',
            '424' => '750',
            '425' => '750',
            '426' => '500',
            '427' => '500',
            '428' => '500',
            '429' => '250',
            '430' => '250',
            '511' => '5000',
            '512' => '3000',
            '513' => '2000',
            '514' => '1500',
            '515' => '1000',
            '516' => '1000',
            '517' => '750',
            '518' => '750',
            '519' => '750',
            '520' => '750',
            '521' => '500',
            '522' => '500',
            '523' => '500',
            '524' => '500',
            '525' => '250',
            '526' => '250',
            '527' => '250',
            '528' => '250',
            '529' => '250',
            '530' => '250',
            '611' => '2000',
            '612' => '1500',
            '613' => '1250',
            '614' => '1000',
            '615' => '800',
            '616' => '650',
            '617' => '500',
            '618' => '400',
            '619' => '350',
            '620' => '300',
            '621' => '250',
            '622' => '200',
            '623' => '175',
            '624' => '150',
            '625' => '125',
            '626' => '100',
            '627' => '100',
            '628' => '75',
            '629' => '50',
            '630' => '25',
            '711' => '500000',
            '712' => '200000',
            '713' => '100000',
            '714' => '50000',
            '715' => '25000',
            '716' => '20000',
            '717' => '15000',
            '718' => '10000',
            '719' => '7000',
            '720' => '5000',
            '721' => '3000',
            '722' => '2000',
            '723' => '1500',
            '724' => '1000',
            '725' => '750',
            '726' => '500',
            '727' => '250',
            '728' => '200',
            '729' => '100',
            '730' => '50',
            '811' => '0',
            '812' => '0',
            '813' => '0',
            '814' => '0',
            '815' => '0',
            '816' => '0',
            '817' => '0',
            '818' => '0',
            '819' => '0',
            '820' => '0',
            '821' => '0',
            '822' => '0',
            '823' => '0',
            '824' => '0',
            '825' => '0',
            '826' => '0',
            '827' => '0',
            '828' => '0',
            '829' => '0',
            '830' => '0',
        );


        $totalId = array();
        $totalHandPlayer = array();
        $totalWinPlayer = array();
        $totalChipsPlayer = array();

        foreach ($users as $user) {
            $totalHandPlayer[$user->player] = 0;
            $totalWinPlayer[$user->player] = 0;
            $totalChipsPlayer[$user->player] = 0;
            $totalId[$user->id] = 0;
        }

        foreach ($champs as $champ) {
            $totalId[$champ->usersId] += $champs_value[$champ->type];
        }

        foreach ($most_hands_played as $most_hand_played) {
            $totalHandPlayer[$most_hand_played->player] = $most_hand_played->rowcount;
        }

        foreach ($most_hands_winners as $most_hands_winner) {
            $totalWinPlayer[$most_hands_winner->player] = $most_hands_winner->rowcount;
        }

        foreach ($cheap_leaders as $cheap_leader) {
            $totalChipsPlayer[$cheap_leader->player] = floor($cheap_leader->sumatory / 100000);
        }

        foreach ($users as $user) {
            if ($user->active == 'Y') {
                $xp = 0;
                $HandPlayer = $totalHandPlayer[$user->player];
                $WinPlayer = $totalWinPlayer[$user->player];
                $ChipsPlayer = $totalChipsPlayer[$user->player];
                for ($i = 0; $i < 5; $i++) {
                    $power = pow(10, $i);
                    $xp += ($this->sign(floor($HandPlayer / (100 * $power))) / 2 + $this->sign(floor($WinPlayer / (100 * $power)))) * (100 * $power)
                        + ($this->sign(floor($HandPlayer / (200 * $power))) / 2 + $this->sign(floor($WinPlayer / (200 * $power)))) * (200 * $power)
                        + ($this->sign(floor($HandPlayer / (500 * $power))) / 2 + $this->sign(floor($WinPlayer / (500 * $power)))) * (500 * $power);
                }
                $xp += $totalId[$user->id] + $HandPlayer + 3 * $WinPlayer + $ChipsPlayer;
                if ($xp == 0)
                    $level = 0;
                else
                    switch ($xp) {
                        case $xp < 100:
                            $level = 0;
                            break;
                        case $xp < 250:
                            $level = 1;
                            break;
                        case $xp < 450:
                            $level = 2;
                            break;
                        case $xp < 700:
                            $level = 3;
                            break;
                        case $xp < 1000:
                            $level = 4;
                            break;
                        case $xp < 1500:
                            $level = 5;
                            break;
                        case $xp < 2500:
                            $level = 6;
                            break;
                        case $xp < 4000:
                            $level = 7;
                            break;
                        case $xp < 6500:
                            $level = 8;
                            break;
                        case $xp < 10000:
                            $level = 9;
                            break;
                        case $xp < 15000:
                            $level = 10;
                            break;
                        case $xp < 25000:
                            $level = 11;
                            break;
                        case $xp < 40000:
                            $level = 12;
                            break;
                        case $xp < 65000:
                            $level = 13;
                            break;
                        case $xp < 100000:
                            $level = 14;
                            break;
                        case $xp < 150000:
                            $level = 15;
                            break;
                        case $xp < 250000:
                            $level = 16;
                            break;
                        case $xp < 400000:
                            $level = 17;
                            break;
                        case $xp < 650000:
                            $level = 18;
                            break;
                        case $xp < 1000000:
                            $level = 19;
                            break;
                        case $xp < 1500000:
                            $level = 20;
                            break;
                        case $xp < 2500000:
                            $level = 21;
                            break;
                        case $xp < 4000000:
                            $level = 22;
                            break;
                        case $xp < 6500000:
                            $level = 23;
                            break;
                        case $xp < 10000000:
                            $level = 24;
                            break;
                        case $xp >= 10000000:
                            $level = 25;
                            break;
                    }
                $rake = $level / 2 + 12.5;
                $user->update(
                    array(
                        'xp' => $xp,
                        'level' => $level,
                        'rake' => $rake
                    )
                );
            }
        }
        $this->flash->success('Experiences, Levels and Rakes are computed . ');
    }

}
