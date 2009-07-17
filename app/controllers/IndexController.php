<?php
namespace Gutshot\Controllers;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {

        if (is_array($this->auth->getIdentity())) {
            $this->view->setTemplateBefore('private');
            $params = array("Command" => "TournamentsList",
                "Fields" => "Name,Status,Description,Auto,Game,Shootout,PW,Private,PermRegister,PermUnregister,PermObserve,PermPlayerChat,PermObserverChat,SuspendChatAllIn,Tables,Seats,StartFull,StartMin,StartCode,StartTime,LateRegMinutes,MinPlayers,RecurMinutes,NoShowMinutes,BuyIn,EntryFee,PrizeBonus,MultiplyBonus,Chips,AddOnChips,TurnClock,TimeBank,BankReset,DisProtect,Level,RebuyLevels,Threshold,MaxRebuys,RebuyCost,RebuyFee,BreakTime,BreakLevels,StopOnChop,Blinds,Payout,UnregLogout",
            );
            $api = $this->getDI()->getApi()->poker($params);

            $user = $this->auth->getPlayer();
            $api->RegisterStatus = array();
            foreach ($api->Name as $tourney) {

                $paramsWaiting = array("Command" => "TournamentsWaiting",
                    "Name" => $tourney
                );
                $apiWaiting = $this->getDI()->getApi()->poker($paramsWaiting);

                if (in_array($user, $apiWaiting->Wait)) {
                    $api->RegisterStatus[] = 'registered';
                } else {
                    $api->RegisterStatus[] = 'unregistered';
                }
            }
            $this->view->setVars(array(
                'logged_in' => is_array($this->auth->getIdentity()),
                'tourney' => $api
            ));
        } else {
            $this->view->setTemplateBefore('public');
            $this->view->setVars(array(
                'logged_in' => is_array($this->auth->getIdentity()),
            ));
        }

    }
}
