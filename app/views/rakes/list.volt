{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("rakes/search", "&larr; Search") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Rakes</h2>
    {% for rake in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Name</th>
            <th>Hand</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>
            <td>{{ rake.usersIn.player }}</td>
            <td>{{ rake.usersOut.player }}</td>
            <td>{{ rake.name }}</td>
            <td>{{ rake.hand }}</td>
            <td>{{ rake.amount }}</td>
            <td>{{ rake.status }}</td>
            <td>{{ rake.comment }}</td>
            <td>{{ date("Y-m-d H:i:s", rake.createdAt) }}</td>
        </tr>
        {% if loop.last %}
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("rakes/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("rakes/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn") }}
                    {{ link_to("rakes/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("rakes/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    {% endif %}
    {% else %}
    No rakes are recorded
    {% endfor %}
</div>