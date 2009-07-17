{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("tourneys/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("tourneys/create", "<i class='icon-plus-sign'></i> Create Tournament", "class": "btn btn-primary")
        }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Search Tournaments</h2>

    <form method="post" action="{{ url("tourneys/list") }}" autocomplete="off">

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="email">Game</label>
        {{ form.render("game") }}
    </div>

    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>

    </form>
</div>