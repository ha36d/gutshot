{{ flashSession.output() }}
{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="pull-left">
            {{ link_to("users/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Create a User</h2>
        <div class="span3">

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
                <label for="password">Password</label>
                {{ form.render("password") }}
            </div>

            <div class="clearfix">
                <label for="location">Location</label>
                {{ form.render("location") }}
            </div>

            <div class="clearfix">
                <label for="location">Gender</label>
                {{ form.render("gender") }}
            </div>

            <div class="clearfix">
                <label for="groupsId">Group</label>
                {{ form.render("groupsId") }}
            </div>

            <div class="clearfix">
                <label for="title">Title</label>
                {{ form.render("title") }}
            </div>
        </div>
        <div class="span3">
            <div class="clearfix">
                <label for="card">Card</label>
                {{ form.render("card") }}
            </div>
            <div class="clearfix">
                <label for="account">Account</label>
                {{ form.render("account") }}
            </div>

            <div class="clearfix">
                <label for="holder">Holder</label>
                {{ form.render("holder") }}
            </div>

            <div class="clearfix">
                <label for="bank">Bank</label>
                {{ form.render("bank") }}
            </div>

            <div class="clearfix">
                <label for="shaba">Shaba</label>
                {{ form.render("shaba") }}
            </div>
        </div>
    </div>
</form>