
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("rings", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Create a Ring</h2>

    <div class="clearfix">
            <label for="game">Game</label>
            {{ form.render("game") }}
    </div>

    <div class="clearfix">
            <label for="password">Password</label>
            {{ form.render("pw") }}
    </div>

    <div class="clearfix">
            <label for="seats">Seats</label>
            {{ form.render("seats") }}
    </div>

    <div class="clearfix">
        <label for="plan">Plan</label>
        {{ form.render("plan") }}
    </div>

    <div class="clearfix">
        <label for="speed">Speed</label>
        {{ form.render("speed") }}
    </div>

</div>

</form>