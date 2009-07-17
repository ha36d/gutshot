{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("deposits/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("deposits/change", "Change Deposit", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Deposits</h2>
    {% for deposit in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Amount</th>
            <th>Reference</th>
            <th>Status</th>
            <th>Type</th>
            <th>Operator</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ deposit.user.player }}</td>
            <td>{{ deposit.amount }}</td>
            <td>{{ deposit.ref }}</td>
            <td>{{ deposit.status == 'Yes' ? 'Success' : 'Failed' }}</td>
            <td>{{ deposit.type }}</td>
            <td>{{ deposit.operator }}</td>
            <td>{{ deposit.comment }}</td>
            <td>{{ date("Y-m-d H:i", deposit.createdAt) }}</td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("deposits/list?page=" ~ page.first, '<i class="icon-fast-backward"></i> First', "class":
                    "btn") }}
                    {{ link_to("deposits/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn ") }}
                    {{ link_to("deposits/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("deposits/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No deposits are recorded
    {% endfor %}
</div>