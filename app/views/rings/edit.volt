<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("rings/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-big btn-success") }}
        </li>
    </ul>

    {{ content() }}

    <div class="center scaffold">
        <h2>Edit Ring</h2>


        <div class="container-fluid">

            <div class="span4">
                {{ form.render("id") }}
                <div class="clearfix">
                    <label for="name">Name - a unique Tounament name, from 1 to 25 characters</label>
                    {{ form.render("name") }}
                </div>

                <div class="clearfix">
                    <label for="game">Game Type</label>
                    {{ form.render("game") }}
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
                <div class="clearfix">
                    <label for="perm_play">play permission token</label>
                    {{ form.render("perm_play") }}
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
                    <label for="perm_observer_chat">observer chat permission token</label>
                    {{ form.render("perm_observer_chat") }}
                </div>

                <div class="clearfix">
                    <label for="suspend_chat_all_in">Select "Yes" to temporarily suspend the table chat when a
                        player moves "all-in"</label>
                    {{ form.render("suspend_chat_all_in") }}
                </div>
            </div>
            <div class="span4">
                <div class="clearfix">
                    <label for="seats">Seats - number of seats per table, from 2 to 10</label>
                    {{ form.render("seats") }}
                </div>

                <div class="clearfix">
                    <label for="smallest_chip">Smallest Chip - Select "Yes" to have the tournament start
                        automatically when all seats have been registered</label>
                    {{ form.render("smallest_chip") }}
                </div>

                <div class="clearfix">
                    <label for="minimum_buy_in">Minimum buy in - the minimum number of registered players that must
                        check their "Start Now" box to start the tournament immediately, from 0(disabled) to
                        10</label>
                    {{ form.render("minimum_buy_in") }}
                </div>
                <div class="clearfix">
                    <label for="maximum_buy_in">Maximum buy in - a code that can be entered in the player module
                        lobby window to start the tournament, from 0 (disabled) to 999999</label>
                    {{ form.render("maximum_buy_in") }}
                </div>

                <div class="clearfix">
                    <label for="default_buy_in">Default buy in - auto-start the tournament in yyyy-mm-dd hh:mm
                        format(0000-00-00 00:00 = disabled)</label>
                    {{ form.render("default_buy_in") }}
                </div>

                <div class="clearfix">
                    <label for="rake">Rake - Set the number of minutes available for registration prior to
                        the start time, from 0 (unlimited) to 999999</label>
                    {{ form.render("rake") }}
                </div>

                <div class="clearfix">
                    <label for="rake_every">Rake every - Set the number of minutes available for late
                        registration, 0 to 999999</label>
                    {{ form.render("rake_every") }}
                </div>

                <div class="clearfix">
                    <label for="rake_max">Rake Max - number of minimum players, from 2 to 1000</label>
                    {{ form.render("rake_max") }}
                </div>
            </div>
            <div class="span4">
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
                    <label for="small_blind">Small Blind - the length of each blinds level, expressed in either minutes or
                        number of hands.</label>
                    {{ form.render("small_blind") }}
                </div>

                <div class="clearfix">
                    <label for="big_blind">Big Blind - the number of levels (0 to 1000) in the rebuy
                        period.</label>
                    {{ form.render("big_blind") }}
                </div>

                <div class="clearfix">
                    <label for="dupe_ips">Duplicate IPs - the maximum number of chips that a player can have to request
                        a rebuy, 0 to 999999</label>
                    {{ form.render("dupe_ips") }}
                </div>

                <div class="clearfix">
                    <label for="rathole_minutes">Rathole Minutes - maximum number of rebuys that each player can make
                        during the rebuy period(-1 = unlimited)</label>
                    {{ form.render("rathole_minutes") }}
                </div>

                <div class="clearfix">
                    <label for="sitout_minutes">Sitout Minutes - amount is deducted from the player's account and added
                        to the prize pool for each rebuy and add-on requested by the players</label>
                    {{ form.render("sitout_minutes") }}
                </div>

                <div class="clearfix">
                    <label for="sitout_relaxed">Sitout Relaxed - amount is deducted from the player's account and added to
                        the house account for each rebuy and add-on requested by the players.</label>
                    {{ form.render("sitout_relaxed") }}
                </div>
            </div>
        </div>
    </div>

</form>