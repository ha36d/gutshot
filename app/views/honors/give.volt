{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="pull-left">
            {{ link_to("honors/list", "&larr; Go Back") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Give Honor/Prize</h2>

        <div class="clearfix">
            <label for="amount">Player</label>
            {{ form.render("usersId") }}
        </div>
        <div class="clearfix">
            <label for="type">Type</label>
            {{ form.render("type") }}
        </div>
        <div class="clearfix">
            <label for="place">Place</label>
            {{ form.render("place") }}
        </div>
        <div class="clearfix">
            <label for="prize">Prize</label>
            {{ form.render("prize") }}
        </div>
        <div class="clearfix">
            <label for="comment">Comment</label>
            {{ form.render("comment") }}
        </div>
        <div class="clearfix">
            {{ submit_button("Give Prize", "class": "btn btn-primary") }}
        </div>

    </div>

</form>