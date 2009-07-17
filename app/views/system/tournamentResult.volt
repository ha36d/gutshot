{{ content() }}

<form method="post">

    <h2>Tournaments Result</h2>

    <div class="well" align="center">

        <table class="perms">
            <tr>
                <td>{{ select('name', Name, 'useEmpty': true, 'emptyText': 'Select a
                    Tournament',
                    'emptyValue': '') }}
                </td>
                <td>{{ select('date', Date, 'useEmpty': true, 'emptyText': 'Select a
                    Date',
                    'emptyValue': '') }}
                </td>
                <td>{{ submit_button('Search', 'class': 'btn btn-primary') }}</td>
            </tr>
        </table>

    </div>
</form>
{% if request.isPost() and tournament is defined %}
<div class="center scaffold">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Results</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                {% if tournament.Error is not empty %}
                {{ tournament.Error }}
                {% else %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Specification</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for key, value in tournament.Data %}
                    <tr>
                        <td>{{ value }}</td>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
                {% endif %}
            </div>

        </div>
    </div>
</div>
{% endif %}