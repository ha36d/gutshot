{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("users/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("users/create", "<i class='icon-plus-sign'></i> Create Users", "class": "btn btn-primary")
        }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Search Users</h2>

    <form method="post" action="{{ url("users/list") }}" autocomplete="off">


    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="player">Player</label>
        {{ form.render("player") }}
    </div>

    <div class="clearfix">
        <label for="email">E-Mail</label>
        {{ form.render("email") }}
    </div>

    <div class="clearfix">
        <label for="groupsId">Group</label>
        {{ form.render("groupsId") }}
    </div>

    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>
    </form>
</div>