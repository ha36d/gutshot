{{ flashSession.output() }}
{{ content() }}
<ul class="pager">
    <li class="pull-left">
        {{ link_to("support/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("support/compose", "Create Message", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Support</h2>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="icon-comment"></span>
        </div>
        <div class="panel-body">
            <ul class="chat">
                {% for support in page %}
                {% if support.type == 'respond' %}

                <li class="right clearfix"><span class="chat-img pull-right">
                            <img data-src="holder.js/50x50?theme=lava&text=SUPP" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <small class=" text-muted"><span class="icon-time"></span>{{ date(" d M H:i",
                                support.createdAt) }}
                            </small>
                            <strong class="pull-right primary-font">Support</strong>
                        </div>
                        <p>
                            {{ support.content }}
                        </p>
                    </div>
                </li>
                {% else %}
                <li class="left clearfix"><span class="chat-img pull-left">
                            <img data-src="holder.js/50x50?theme=sky&text=USER" class="img-circle">
                        </span>

                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">{{ support.users.player }}</strong>
                            <small class="pull-right text-muted">
                                <span class="icon-time"></span>{{ date(" d M H:i", support.createdAt) }}
                            </small>
                        </div>
                        <p>
                            {{ support.content }}
                        </p>
                    </div>
                </li>
                {% endif %}

                {% else %}
                No support is recorded
                {% endfor %}
            </ul>
        </div>
        <div class="panel-footer">
            <div>
                <form method="post" class="form-inline">
                    <div class="clearfix">
                        {{ form.render("content") }}
                        {{ submit_button("Send", "class": "btn btn-primary") }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>