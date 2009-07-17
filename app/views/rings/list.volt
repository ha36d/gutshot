{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("rings/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("rings/create", "Create Ring", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Rings</h2>
    {% for ring in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Name</th>
            <th>Game</th>
            <th>Seats</th>
            <th>Buy-in</th>
            <th>Rake</th>
            <th>Blinds</th>
            <th>Clock</th>
            <th>Status</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>
            <td>{{ ring.name }}</td>
            <td>{{ ring.game }}</td>
            <td>{{ ring.seats }}</td>
            <td>{{ ring.minimum_buy_in ~ "/" ~ ring.maximum_buy_in ~ "(" ~ ring.default_buy_in ~ ")" }}</td>
            <td>{{ ring.rake ~ "/" ~ ring.rake_every ~ "(" ~ ring.rake_max ~ ")" }}</td>
            <td>{{ ring.small_blind ~ "/" ~ ring.big_blind }}</td>
            <td>{{ ring.turn_clock ~ "/" ~ ring.time_bank }}</td>
            <td>{{ ring.status }}</td>
            {% if ring.status == 'private' %}
            <td><div class="btn-group">
                {{ link_to("rings/reject/" ~ ring.id, '<i class="icon-remove"></i> Reject', "class": "btn btn-mini")}}
                {{ link_to("rings/accept/" ~ ring.id, '<i class="icon-check"></i> Accept', "class": "btn btn-mini")}}
            </div>
            </td>
            {% else %}
            <td><div class="btn-group">
                {{ link_to("rings/edit/" ~ ring.id, '<i class="icon-pencil"></i> Edit', "class": "btn btn-mini") }}
                {{ link_to("rings/delete/" ~ ring.id, '<i class="icon-remove"></i> Delete', "class": "btn btn-mini")}}
                {{ link_to("rings/online/" ~ ring.id, '<i class="icon-eye-open"></i> Online', "class": "btn btn-mini")}}
                {{ link_to("rings/offline/" ~ ring.id, '<i class="icon-eye-close"></i> Offline', "class":"btn btn-mini") }}
                {{ link_to("rings/pause/" ~ ring.id, '<i class="icon-pause"></i> Pause', "class": "btn btn-mini")}}
                {{ link_to("rings/resume/" ~ ring.id, '<i class="icon-play"></i> Resume', "class": "btn btn-mini")}}
                {{ link_to("rings/message/" ~ ring.id, '<i class="icon-inbox"></i> Message', "class": "btn btn-mini")}}
            </div>
            </td>
            {% endif %}
        </tr>
        {% if loop.last %}
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("rings/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("rings/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn ") }}
                    {{ link_to("rings/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("rings/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    {% endif %}
    {% else %}
    No rings are recorded
    {% endfor %}
</div>