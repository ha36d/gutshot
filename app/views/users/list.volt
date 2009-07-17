{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("users/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("users/create", "Create Users", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Users</h2>
    {% for user in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Name</th>
            <th>Email</th>
            <th>Group</th>
            <th>Banned?</th>
            <th>Suspended?</th>
            <th>Confirmed?</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ user.player }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.group.name }}</td>
            <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
            <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("users/edit/" ~ user.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}
            </td>
            <td width="12%">{{ link_to("users/delete/" ~ user.id, '<i class="icon-remove"></i> Delete', "class": "btn")
                }}
            </td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("users/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("users/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class":
                    "btn ") }}
                    {{ link_to("users/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn")
                    }}
                    {{ link_to("users/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn")
                    }}
                    {{ link_to('#', '<i class="icon-info-sign"></i> Page ' ~ page.current ~ " of " ~ page.total_pages , "class": "btn list disabled") }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No users are recorded
    {% endfor %}
</div>