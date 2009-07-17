{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("tourneys/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("tourneys/create", "Create Tournament", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Tournaments</h2>
    {% for tournament in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Name</th>
            <th>Game</th>
            <th>Tables</th>
            <th>Seats</th>
            <th>Buy In</th>
            <th>Status</th>
            <th>Operations</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ tournament.name }}</td>
            <td>{{ tournament.game }}</td>
            <td>{{ tournament.tables }}</td>
            <td>{{ tournament.seats }}</td>
            <td>{{ tournament.buy_in }}</td>
            <td>{{ tournament.status }}</td>
            <td><div class="btn-group">
                {{ link_to("tourneys/edit/" ~ tournament.id, '<i class="icon-pencil"></i> Edit', "class":
                "btn btn-mini") }}
                {{ link_to("tourneys/delete/" ~ tournament.id, '<i class="icon-remove"></i> Delete',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/online/" ~ tournament.id, '<i class="icon-eye-open"></i> Online',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/offline/" ~ tournament.id, '<i class="icon-eye-close"></i> Offline',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/offlineNow/" ~ tournament.id, '<i class="icon-eye-close"></i> Offline Now',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/removeNoShows/" ~ tournament.id, '<i class="icon-remove"></i> Remove No Shows',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/start/" ~ tournament.id, '<i class="icon-play"></i> Start',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/pause/" ~ tournament.id, '<i class="icon-pause"></i> Pause',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/resume/" ~ tournament.id, '<i class="icon-play"></i> Resume',
                "class": "btn btn-mini") }}
                {{ link_to("tourneys/message/" ~ tournament.id, '<i class="icon-inbox"></i> Message', "class": "btn btn-mini")}}
            </div>
            </td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("tourneys/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("tourneys/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn") }}
                    {{ link_to("tourneys/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("tourneys/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No tourney are recorded
    {% endfor %}
</div>