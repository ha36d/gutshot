{{ content() }}
<ul class="pager">
    <li class="pull-left">
        {{ link_to("rings/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("rings/create", "<i class='icon-plus-sign'></i> Create Ring", "class": "btn btn-primary") }}
    </li>
</ul>

<div class="center scaffold">
    <h2>Search rings</h2>

    <form method="post" action="{{ url("rings/list") }}" autocomplete="off">

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="game">Game</label>
        {{ form.render("game") }}
    </div>

    <div class="clearfix">
        <label for="private">Private</label>
        {{ form.render("private") }}
    </div>

    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>

    </form>
</div>