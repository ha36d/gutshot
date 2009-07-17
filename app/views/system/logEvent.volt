{{ content() }}

<form method="post">

    <h2>Event Logs</h2>

    <div class="well" align="center">

        <table class="perms">
            <tr>
                <td>{{ select('date', LogsEvent, 'useEmpty': true, 'emptyText': 'Select a
                    Date',
                    'emptyValue': '') }}
                </td>
                <td>{{ submit_button('Search', 'class': 'btn btn-primary') }}</td>
            </tr>
        </table>

    </div>
</form>

<div class="center scaffold">
    {% if request.isPost() %}
    {% if events is defined %}
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Events</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">

                {% for event in events %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Log</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ event }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No logs are recorded
                {% endfor %}

            </div>
        </div>
    </div>
    {% elseif error is defined %}

    {{ error }}

    {% endif %}
    {% endif %}
</div>