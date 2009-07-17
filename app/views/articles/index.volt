{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}

<div class="center scaffold">
    {% if article is not empty %}
    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("articles/" ~ type, "&larr; Go Back") }}
        </li>
    </ul>
    <h2>{{ article.title }}</h2>

    <div class="well" align="center">
        <div class="clearfix">
            {{ article.content }}
        </div>
    </div>
    {% else %}
    <ul class="nav nav-tabs">
        {% for name in types %}
        {% if name == active %}
        <li class="active"><a href="#">{{ name|capitalize }}</a></li>
        {% else %}
        <li>{{ link_to("articles/" ~ name, name|capitalize) }}</li>
        {% endif %}
        {% endfor %}
    </ul>
    {% for news in page %}
    {% if loop.first %}
    <table class="table table-striped border-less" align="center" id="table">
        <thead>
        <tr>
            <th>{{ active|capitalize }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>
            <td>{{ link_to("articles/" ~ news.id, news.title) }}</td>
            <td>{{ date("d M Y", news.createdAt) }}</td>
        </tr>
        {% if loop.last %}
        </tbody>
    </table>
    {% endif %}
    {% else %}
    No {{ active }} are recorded
    {% endfor %}

    {% endif %}
</div>
<script>
    $(document).ready(function() {
        $('#table').dataTable({
            "order": [[1, 'desc']]
        });
    });
</script>