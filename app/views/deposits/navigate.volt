{% for deposit in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Aomunt</th>
        <th>Date</th>
        <th>Reference</th>
        <th>Status?</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ deposit.amount }}</td>
        <td>{{ date("d M Y H:i",deposit.createdAt) }}</td>
        <td>{{ deposit.ref }}</td>
        <td>{{ deposit.status == 'Yes' ? 'Success' : 'Failed' }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("deposits/navigate?page=" ~ page.first, '<i class="icon-fast-backward"></i> First', "class": "btn
                navigate") }}
                {{ link_to("deposits/navigate?page=" ~ page.before, '<i class="icon-step-backward"></i>
                Previous', "class": "btn navigate") }}
                {{ link_to("deposits/navigate?page=" ~ page.next, '<i class="icon-step-forward"></i> Next',
                "class": "btn navigate") }}
                {{ link_to("deposits/navigate?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last',
                "class": "btn navigate") }}
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