{{ flashSession.output() }}
{{ content() }}
<div class="center scaffold">
    <h2>Support</h2>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="icon-comment"></span>
        </div>
        <div class="panel-body">
            <ul class="chat">
            </ul>
        </div>
        <div class="panel-footer">
            <div>
                <form method="post">
                    <div class="clearfix">
                        {{ form.render("usersId") }}
                    </div>
                    <div class="clearfix">
                        {{ form.render("content") }}
                    </div>
                    <div class="clearfix">
                        {{ submit_button("Send", "class": "btn btn-primary") }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

