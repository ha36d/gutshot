{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("groups/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("groups/create", "Create groups", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Groups</h2>
    {% for group in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Active?</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ group.id }}</td>
            <td>{{ group.name }}</td>
            <td>{{ group.active == 'Y' ? 'Yes' : 'No' }}</td>
            <td width="12%">{{ link_to("groups/edit/" ~ group.id, '<i class="icon-pencil"></i> Edit', "class": "btn") }}
            </td>
            <td width="12%">{{ link_to("groups/delete/" ~ group.id, '<i class="icon-remove"></i> Delete', "class":
                "btn") }}
            </td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("groups/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("groups/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn") }}
                    {{ link_to("groups/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("groups/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No groups are recorded
    {% endfor %}
</div>