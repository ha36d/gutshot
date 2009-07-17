{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("articles/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("articles/create", "Create Article", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Articles</h2>
    {% for article in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Author</th>
            <th>Operations</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ article.title }}</td>
            <td>{{ article.type }}</td>
            <td>{{ article.users.player }}</td>
            <td width="12%">{{ link_to("articles/edit/" ~ article.id, '<i class="icon-check"></i> Edit', "class": "btn")
                }}
            </td>
            <td width="12%">{{ link_to("articles/delete/" ~ article.id, '<i class="icon-check"></i> Delete', "class":
                "btn") }}
            </td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("articles/list?page=" ~ page.first, '<i class="icon-fast-backward"></i> First', "class":
                    "btn") }}
                    {{ link_to("articles/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn ") }}
                    {{ link_to("articles/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("articles/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No articles are recorded
    {% endfor %}
</div>