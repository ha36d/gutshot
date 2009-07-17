{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("cashouts/search", "&larr; Search") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Cashouts</h2>
    {% for cashout in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Card</th>
            <th>Account</th>
            <th>Holder</th>
            <th>Bank</th>
            <th>Shaba</th>
            <th>Comment</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status?</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ cashout.user.player }}</td>
            <td>{{ cashout.card }}</td>
            <td>{{ cashout.account }}</td>
            <td>{{ cashout.holder }}</td>
            <td>{{ cashout.bank }}</td>
            <td>{{ cashout.shaba }}</td>
            <td>{{ cashout.comment }}</td>
            <td>{{ cashout.amount }}</td>
            <td>{{ date("d M Y H:i",cashout.createdAt) }}</td>
            {% if cashout.status == 'Yes' %}
            <td>Paid at {{ date("d M Y H:i",cashout.paidAt) }}</td>
            {% elseif cashout.status == 'No' %}
            <td>
                <div class="btn-group">
                    {{ link_to("cashouts/pay/" ~ cashout.id, '<i class="icon-check"></i> Pay', "class": "btn")
                    }}
                    {{ link_to("cashouts/reject/" ~ cashout.id, '<i class="icon-remove"></i> Cancel',
                    "class": "btn") }}
                </div>
            </td>
            {% elseif cashout.status == 'Cancel' %}
            <td>Canceled by User</td>
            {% else %}
            <td>The request is rejected by Admin</td>
            {% endif %}
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("cashouts/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("cashouts/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn ") }}
                    {{ link_to("cashouts/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("cashouts/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~
                        page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No cashouts are recorded
    {% endfor %}
</div>