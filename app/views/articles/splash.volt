<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("articles/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Publish", "class": "btn btn-success") }}
        </li>
    </ul>

    {{ content() }}

    <div class="center scaffold">
        <h2>Publish Splash</h2>

        <div class="clearfix">
            <label for="content">Content</label>
            <textarea id="content" name="content"></textarea>
        </div>
        <div class="clearfix">
            <label for="type">Type</label>
            {{ select('type', ['New':'Show the text if it has been edited since the player previous login', 'Yes':'Site
            News should be displayed to each player immediately after they log in', 'No':'Site News should not be
            displayed to each player immediately after they log in'], 'useEmpty': false, 'value': 'New') }}
        </div>
    </div>
</form>