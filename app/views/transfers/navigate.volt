{% for rake in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
    <tr>
        <th>Player</th>
        <th>Amount</th>
        <th>Operations</th>
    </tr>
    </thead>
    {% endif %}
    <tbody>
    <tr>
        <td>{{ rake.player}}</td>
        <td>{{ rake.amounts }}</td>
        <td width="12%">{{ link_to("rakes/done/" ~ rake.fromId, '<i class="icon-remove"></i> Done',
            "class": "btn")
            }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
    <tbody>
    <tr>
        <td colspan="10" align="right">
            <div class="btn-group">
                {{ link_to("rakes/navigate", '<i class="icon-fast-backward"></i> First', "class": "btn
                navigate") }}
                {{ link_to("rakes/navigate?page=" ~ page.before, '<i class="icon-step-backward"></i>
                Previous',
                "class": "btn navigate") }}
                {{ link_to("rakes/navigate?page=" ~ page.next, '<i class="icon-step-forward"></i> Next',
                "class":
                "btn navigate") }}
                {{ link_to("rakes/navigate?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last',
                "class":
                "btn navigate") }}
                <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
            </div>
        </td>
    </tr>
    <tbody>
</table>
{% endif %}
{% else %}
No rakes are recorded
{% endfor %}