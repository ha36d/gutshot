{{ content() }}

<ul class="pager">
    <li class="pull-right">
        {{ link_to("support/compose", "Create Message", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Support</h2>
    {% for support in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>From</th>
            <th>Date</th>
            <th>Operations</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        {% if support.toStatus == 'unread' and support.type == 'request' %}
        <tr class="alert alert-info">
            {% else %}
        <tr>
            {% endif %}
            <td>{{ support.users.player }}</td>
            <td>{{ date("Y M d H:i", support.createdAt) }}</td>
            <td>{{ link_to("support/conversation/" ~ support.usersId, '<i class="icon-check"></i>
                Conversation',
                "class": "btn") }}
            </td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("support/new" ~ page.first, '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("support/new?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class":
                    "btn ") }}
                    {{ link_to("support/new?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn")
                    }}
                    {{ link_to("support/new?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn")
                    }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a>
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No support are recorded
    {% endfor %}
</div>