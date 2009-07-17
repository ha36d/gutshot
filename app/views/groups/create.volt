{{ flashSession.output() }}
{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="pull-left">
            {{ link_to("groups/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Create a Group</h2>

        <div class="clearfix">
            <label for="name">Name</label>
            {{ form.render("name") }}
        </div>

        <div class="clearfix">
            <label for="active">Active?</label>
            {{ form.render("active") }}
        </div>

    </div>

</form>