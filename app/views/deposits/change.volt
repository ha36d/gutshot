{{ flashSession.output() }}
{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("deposits/list", "&larr; Go Back") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Increase/Decrease Balance</h2>

        <div class="clearfix">
            <label for="usersId">User</label>
            {{ form.render("usersId") }}
        </div>

        <div class="clearfix">
            <label for="amount">Amount</label>
            {{ form.render("amount") }}
        </div>

        <div class="clearfix">
            <label for="amount">Amount</label>
            {{ form.render("change") }}
        </div>

        <div class="clearfix">
            <label for="amount">Comment</label>
            {{ form.render("comment") }}
        </div>

        <div class="clearfix">
            {{ submit_button("Done", "class": "btn btn-primary") }}
        </div>

    </div>

</form>