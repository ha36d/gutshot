{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("transfers/search", "&larr; Search") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Transfers</h2>
    {% for transfer in page.items %}
    {% if loop.first %}
    <table class="table table-bordered" align="center">
        <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Comment</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>
            <td>{{ transfer.userOut.player }}</td>
            <td>{{ transfer.userIn.player }}</td>
            <td>{{ transfer.comment }}</td>
            <td>{{ transfer.amount }}</td>
            <td>{{ date("Y-m-d H:i:s", transfer.createdAt) }}</td>
        </tr>
        {% if loop.last %}
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("transfers/list", '<i class="icon-fast-backward"></i> First', "class":
                    "btn list")
                    }}
                    {{ link_to("transfers/list?page=" ~ page.before, '<i class="icon-step-backward"></i>
                    Previous', "class": "btn list") }}
                    {{ link_to("transfers/list?page=" ~ page.next, '<i class="icon-step-forward"></i>
                    Next',
                    "class": "btn list") }}
                    {{ link_to("transfers/list?page=" ~ page.last, '<i class="icon-fast-forward"></i>
                    Last',
                    "class": "btn list") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    {% endif %}
    {% else %}
    No transfers are recorded
    {% endfor %}
</div>