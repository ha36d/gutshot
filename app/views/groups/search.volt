{{ content() }}
<ul class="pager">
    <li class="pull-left">
        {{ link_to("groups/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("groups/create", "<i class='icon-plus-sign'></i> Create Groups", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Search groups</h2>

    <form method="post" action="{{ url("groups/list") }}" autocomplete="off">
    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="active">Active?</label>
        {{ form.render("active") }}
    </div>
    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>

    </form>
</div>