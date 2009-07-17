{{ content() }}

<form method="post">

    <h2>Tournaments Details</h2>

    <div class="well" align="center">

        <table class="perms">
            <tr>
                <td>{{ select('name', Tournaments, 'useEmpty': true, 'emptyText': 'Select a
                    Tournament',
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
        <li class="active"><a href="#A" data-toggle="tab">Tournament</a></li>
        <li><a href="#B" data-toggle="tab">Playing</a></li>
        <li><a href="#C" data-toggle="tab">Waiting</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Specification</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for key, value in tournament %}
                    <tr>
                        <td>{{ key }}</td>
                        <td>{{ value }}</td>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="B">
                {% for play in playing.Player %}
                {% set index = loop.index0 %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Chips</th>
                        <th>Net</th>
                        <th>Away</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ playing.Player[index] }}</td>
                        <td>{{ playing.Chips[index] }}</td>
                        <td>{{ playing.Net[index] }}</td>
                        <td>{{ playing.Away[index] }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No Tournament player are recorded
                {% endfor %}
            </div>

            <div class="tab-pane" id="C">
                {% for wait in waiting.Wait %}
                {% set index = loop.index0 %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Players</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ waiting.Wait[index] }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No Tournament waiter are recorded
                {% endfor %}
            </div>

        </div>
    </div>
</div>
{% endif %}