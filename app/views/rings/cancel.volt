{{ content() }}

{% for ring in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Name</th>
        <th>Game</th>
        <th>Seats</th>
        <th>Minimum buy</th>
        <th>Maximum buy</th>
        <th>Operations</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ ring.name }}</td>
        <td>{{ ring.game }}</td>
        <td>{{ ring.seats }}</td>
        <td>{{ ring.minimum_buy_in }}</td>
        <td>{{ ring.maximum_buy_in }}</td>
        <td width="12%">{{ link_to("rings/deleteRequest/" ~ ring.id, '<i class="icon-remove"></i> Delete Request', "class": "btn cancel") }}</td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("rings/navigate?page=" ~ page.first, '<i class="icon-fast-backward"></i> First', "class": "btn navigate") }}
                {{ link_to("rings/navigate?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn navigate") }}
                {{ link_to("rings/navigate?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn navigate") }}
                {{ link_to("rings/navigate?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn navigate") }}
                <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
            </div>
        </td>
    </tr>
    <tbody>
</table>
{% endif %}
{% else %}
No rings are recorded
{% endfor %}