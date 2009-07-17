{% for cashout in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Card</th>
        <th>Account</th>
        <th>Holder</th>
        <th>Bank</th>
        <th>Amount</th>
        <th>Status?</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ cashout.card }}</td>
        <td>{{ cashout.account }}</td>
        <td>{{ cashout.holder }}</td>
        <td>{{ cashout.bank }}</td>
        <td>{{ cashout.amount }}</td>
        <td>{{ cashout.status == 'Yes' ? 'Paid' : link_to("cashouts/cancel/" ~ cashout.id, '<i class="icon-remove"></i> Cancel', "class": "btn cancel") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("cashouts/navigate", '<i class="icon-fast-backward"></i> First', "class":
                "btn navigate") }}
                {{ link_to("cashouts/navigate?page=" ~ page.before, '<i
                    class="icon-step-backward"></i> Previous', "class": "btn navigate") }}
                {{ link_to("cashouts/navigate?page=" ~ page.next, '<i class="icon-step-forward"></i>
                Next', "class": "btn navigate") }}
                {{ link_to("cashouts/navigate?page=" ~ page.last, '<i class="icon-fast-forward"></i>
                Last', "class": "btn navigate") }}
                <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
            </div>
        </td>
    </tr>
    <tbody>
</table>
{% endif %}
{% else %}
No cashouts are recorded
{% endfor %}