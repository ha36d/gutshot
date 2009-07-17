{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("rings/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-big btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Create Ring</h2>


        <div class="container-fluid">

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
                    <label for="smallest_chip">Smallest Chip - The smallest chip allowed at the table. Buy-in, rake, blinds, and player bets must all be a multiple of this value.</label>
                    {{ form.render("smallest_chip") }}
                </div>

                <div class="clearfix">
                    <label for="minimum_buy_in">Minimum buy-in - Select the minimum buy-in for this table, up to 1 billion chips.</label>
                    {{ form.render("minimum_buy_in") }}
                </div>
                <div class="clearfix">
                    <label for="maximum_buy_in">Maximum buy-in - Select the maximum buy-in for this table, up to 1 billion chips.</label>
                    {{ form.render("maximum_buy_in") }}
                </div>

                <div class="clearfix">
                    <label for="default_buy_in">Default buy-in - Select the default buy-in for this table.</label>
                    {{ form.render("default_buy_in") }}
                </div>

                <div class="clearfix">
                    <label for="rake">Rake - Select the number of chips to rake from the pot.</label>
                    {{ form.render("rake") }}
                </div>

                <div class="clearfix">
                    <label for="rake_every">Rake every - Select the number of chips that must be collected into each pot before the "Rake" amount is deducted.</label>
                    {{ form.render("rake_every") }}
                </div>

                <div class="clearfix">
                    <label for="rake_max">Rake max - Select the maximum number of chips that can be raked in a single hand.</label>
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
                    <label for="small_blind">Small blind - This is the small blind.</label>
                    {{ form.render("small_blind") }}
                </div>

                <div class="clearfix">
                    <label for="big_blind">Big blind - This is the big blind and is normally set to twice the value of the small blind..</label>
                    {{ form.render("big_blind") }}
                </div>

                <div class="clearfix">
                    <label for="dupe_ips">Duplicate IPs - Set this option to "No" to prevent a player from joining the table twice simultaneously.</label>
                    {{ form.render("dupe_ips") }}
                </div>

                <div class="clearfix">
                    <label for="rathole_minutes">Rathole minutes - When a player leaves the table, this is the minimum number of minutes (0 to 120) they must wait if they want to return with a smaller stack.</label>
                    {{ form.render("rathole_minutes") }}
                </div>

                <div class="clearfix">
                    <label for="sitout_minutes">Sitout Minutes - This is the maximum number of consecutive minutes (1 to 120) that a player can sit out before being automatically removed from the table.</label>
                    {{ form.render("sitout_minutes") }}
                </div>

                <div class="clearfix">
                    <label for="sitout_relaxed">Sitout relaxed - Set to Yes to keep sitout-expired players at the table if the waiting list is empty.
                    </label>
                    {{ form.render("sitout_relaxed") }}
                </div>
            </div>
        </div>
    </div>

</form>