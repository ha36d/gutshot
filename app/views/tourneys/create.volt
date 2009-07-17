{{ content() }}

<form method="post" autocomplete="off">
    <ul class="pager">
        <li class="pull-left">
            {{ link_to("tourneys/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-big btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Create tournament</h2>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
            <li><a href="#B" data-toggle="tab">Other</a></li>
        </ul>

        <div class="tabbable">
            <div class="tab-content">
                <div class="tab-pane active" id="A">

                    <div class="span4">

                        <div class="clearfix">
                            <label for="name">Name - a unique Tounament name, from 1 to 25 characters</label>
                            {{ form.render("name") }}
                        </div>

                        <div class="clearfix">
                            <label for="game">Game Type</label>
                            {{ form.render("game") }}
                        </div>

                        <div class="clearfix">
                            <label for="shootout">Shootout - set to "Yes" for a shootout format or "No" for a standard
                                format</label>
                            {{ form.render("shootout") }}
                        </div>

                        <div class="clearfix">
                            <label for="description">Description - optional tournament description, up to 500
                                characters</label>
                            {{ form.render("description") }}
                        </div>

                        <div class="clearfix">
                            <label for="auto">Auto - set to "Yes" or "No" to put game online when server is
                                started</label>
                            {{ form.render("auto") }}
                        </div>

                        <div class="clearfix">
                            <label for="pw">PW - (optional) specify a password needed to register</label>
                            {{ form.render("pw") }}
                        </div>

                        <div class="clearfix">
                            <label for="private">Private - set to "Yes" to prevent observing without the password or
                                "No" to allow observers</label>
                            {{ form.render("private") }}
                        </div>
                    </div>
                    <div class="span4">
                        <div class="clearfix">
                            <label for="perm_register">register permission token</label>
                            {{ form.render("perm_register") }}
                        </div>

                        <div class="clearfix">
                            <label for="perm_unregister">unregister permission token</label>
                            {{ form.render("perm_unregister") }}
                        </div>

                        <div class="clearfix">
                            <label for="perm_observe">observe permission token</label>
                            {{ form.render("perm_observe") }}
                        </div>

                        <div class="clearfix">
                            <label for="perm_player_chat">player chat permission token</label>
                            {{ form.render("perm_player_chat") }}
                        </div>

                        <div class="clearfix">
                            <label for="perm_player_chat">observer chat permission token</label>
                            {{ form.render("perm_player_chat") }}
                        </div>

                        <div class="clearfix">
                            <label for="suspend_chat_all_in">Select "Yes" to temporarily suspend the table chat when a
                                player moves "all-in"</label>
                            {{ form.render("suspend_chat_all_in") }}
                        </div>

                        <div class="clearfix">
                            <label for="tables">Tables - number of tables, from 1 to 100</label>
                            {{ form.render("tables") }}
                        </div>

                        <div class="clearfix">
                            <label for="seats">Seats - number of seats per table, from 2 to 10</label>
                            {{ form.render("seats") }}
                        </div>

                        <div class="clearfix">
                            <label for="start_full">StartFull - Select "Yes" to have the tournament start automatically
                                when all seats have been registered</label>
                            {{ form.render("start_full") }}
                        </div>

                        <div class="clearfix">
                            <label for="start_min">StartMin - the minimum number of registered players that must check
                                their "Start Now" box to start the tournament immediately, from 0(disabled) to
                                10</label>
                            {{ form.render("start_min") }}
                        </div>
                    </div>
                    <div class="span4">
                        <div class="clearfix">
                            <label for="start_code">StartCode - a code that can be entered in the player module lobby
                                window to start the tournament, from 0 (disabled) to 999999</label>
                            {{ form.render("start_code") }}
                        </div>

                        <div class="clearfix">
                            <label for="start_time">StartTime - auto-start the tournament in yyyy-mm-dd hh:mm
                                format(0000-00-00 00:00 = disabled)</label>
                            {{ form.render("start_time") }}
                        </div>

                        <div class="clearfix">
                            <label for="reg_period">RegPeriod - Set the number of minutes available for registration
                                prior to the start time, from 0 (unlimited) to 999999</label>
                            {{ form.render("reg_period") }}
                        </div>

                        <div class="clearfix">
                            <label for="late_reg_minutes">LateRegMinutes - Set the number of minutes available for late
                                registration, 0 to 999999</label>
                            {{ form.render("late_reg_minutes") }}
                        </div>

                        <div class="clearfix">
                            <label for="min_players">MinPlayers - number of minimum players, from 2 to 1000</label>
                            {{ form.render("min_players") }}
                        </div>

                        <div class="clearfix">
                            <label for="recur_minutes">RecurMinutes - the number of minutes (0 to 999999) to add to the
                                Start Time for an auto-recurring tournament (if start time is not disabled).</label>
                            {{ form.render("recur_minutes") }}
                        </div>

                        <div class="clearfix">
                            <label for="no_show_minutes">NoShowMinutes - number from 0 to 999999 to automatically remove
                                "no-show" players from the tournament at the end of the specified minute.</label>
                            {{ form.render("no_show_minutes") }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="B">
                    <div class="span4">

                        <div class="clearfix">
                            <label for="buy_in">BuyIn - the buy-in for this tournament, up to 1 billion chips.</label>
                            {{ form.render("buy_in") }}
                        </div>

                        <div class="clearfix">
                            <label for="entry_fee">EntryFee - entry fee for this tournament that is added to the buy-in
                                but is kept by the "house" and does not go into the prize pool</label>
                            {{ form.render("entry_fee") }}
                        </div>

                        <div class="clearfix">
                            <label for="prize_bonus">PrizeBonus - the number of house chips to add to the total prize
                                pool</label>
                            {{ form.render("prize_bonus") }}
                        </div>

                        <div class="clearfix">
                            <label for="multiply_bonus">MultiplyBonus - Set to "Yes" to multiply the prize bonus by the
                                number of entrants, "No" to add the prize bonus as-is, or "Min" to treat the prize bonus
                                as a guaranteed minimum prize pool.</label>
                            {{ form.render("multiply_bonus") }}
                        </div>

                        <div class="clearfix">
                            <label for="chips">Chips - number of starting chips, from 0 to 25000</label>
                            {{ form.render("chips") }}
                        </div>

                        <div class="clearfix">
                            <label for="add_on_chips">AddOnChips - the number of add-on chips (50000 max) to be offered
                                at the end of the rebuy period for the same price as a regular rebuy. Use 0 for no
                                add-on.</label>
                            {{ form.render("add_on_chips") }}
                        </div>


                        <div class="clearfix">
                            <label for="turn_clock">TurnClock - number of seconds, from 10 to 120, that the player has
                                to act on each turn.</label>
                            {{ form.render("turn_clock") }}
                        </div>

                        <div class="clearfix">
                            <label for="time_bank">TimeBank - number of seconds, from 0 to 600, available to each player
                                on request ("Request Time").</label>
                            {{ form.render("time_bank") }}
                        </div>

                    </div>
                    <div
                    = class="span4">
                    <div class="clearfix">
                        <label for="bank_reset">BankReset - number of hands, from 0 to 999999, that must be played
                            before a player's time bank is automatically refilled. (0 is disabled)</label>
                        {{ form.render("bank_reset") }}
                    </div>

                    <div class="clearfix">
                        <label for="dis_protect">DisProtect - Select Yes to automatically activate a player's time bank
                            if they disconnect.</label>
                        {{ form.render("dis_protect") }}
                    </div>

                    <div class="clearfix">
                        <label for="level">Level - the length of each blinds level, expressed in either minutes or
                            number of hands.</label>
                        {{ form.render("level") }}
                    </div>

                    <div class="clearfix">
                        <label for="rebuy_levels">RebuyLevels - the number of levels (0 to 1000) in the rebuy
                            period.</label>
                        {{ form.render("rebuy_levels") }}
                    </div>

                    <div class="clearfix">
                        <label for="threshold">Threshold - the maximum number of chips that a player can have to request
                            a rebuy, 0 to 999999</label>
                        {{ form.render("threshold") }}
                    </div>

                    <div class="clearfix">
                        <label for="max_rebuys">MaxRebuys - maximum number of rebuys that each player can make during
                            the rebuy period(-1 = unlimited)</label>
                        {{ form.render("max_rebuys") }}
                    </div>
                </div>
                <div class="span4">
                    <div class="clearfix">
                        <label for="rebuy_cost">RebuyCost - amount is deducted from the player's account and added to
                            the prize pool for each rebuy and add-on requested by the players</label>
                        {{ form.render("rebuy_cost") }}
                    </div>

                    <div class="clearfix">
                        <label for="rebuy_fee">RebuyFee - amount is deducted from the player's account and added to the
                            house account for each rebuy and add-on requested by the players.</label>
                        {{ form.render("rebuy_fee") }}
                    </div>

                    <div class="clearfix">
                        <label for="break_time">BreakTime - the number of minutes for each rest break, up to 60 (0 =
                            disable).</label>
                        {{ form.render("break_time") }}
                    </div>

                    <div class="clearfix">
                        <label for="break_levels">BreakLevels - number of levels (up to 1000) that are in between each
                            rest break (0 = disable).</label>
                        {{ form.render("break_levels") }}
                    </div>

                    <div class="clearfix">
                        <label for="stop_on_chop">StopOnChop - Set this option to Yes to stop a tournament early if the
                            remaining players are all due an equal payout.</label>
                        {{ form.render("stop_on_chop") }}
                    </div>

                    <div class="clearfix">
                        <label for="blinds">Blinds - blind schedule in the format of "SB1/BB1/Ante1, SB2/BB2/Ante2", etc
                            . Leave blank for the default schedule.</label>
                        {{ form.render("blinds") }}
                    </div>

                    <div class="clearfix">
                        <label for="payout">Payout - payout structure in the format of "2-4, 100.00|5-7, 65.00,
                            35.00|8-10, 50.00, 30.00, 20.00" . Leave blank for the default structure .</label>
                        {{ form.render("payout") }}
                    </div>

                    <div class="clearfix">
                        <label for="unreg_logout">UnregLogout - "Yes" or "No", indicates if player should be
                            unregistered if they log out .</label>
                        {{ form.render("unreg_logout") }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>
</div>