{{ content() }}
<form method="post" autocomplete="off">
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("rings/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Send", "class": "btn btn-big btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Message</h2>

        <div class="span4">
            {{ hidden_field('id', 'value':ring.id) }}
            <div class="clearfix">
                <label for="message">Message</label>
                {{ text_field('message') }}
            </div>

        </div>
    </div>

</form>