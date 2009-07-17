{{ content() }}

<h2>Server Status</h2>


<div class="center scaffold">
    <div class="well" align="center">
        {% if Stats.Error is not empty %}
        {{ Stats.Error }}
        {% else %}
        <table class="table table-bordered table-striped" align="center">
            <thead>
            <tr>
                <th>Specification</th>
                <th>Value</th>
            </tr>
            </thead>
            {% for key, value in Stats %}
            <tbody>
            <tr>
                <td>{{ key }}</td>
                <td>{{ value }}</td>
            </tr>
            </tbody>
            {% endfor %}
        </table>
        {% endif %}
        <table class="table table-bordered table-striped" align="center">
            <thead>
            <tr>
                <th>Specification</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ link_to('cashouts/list', 'Number of pending cashouts') }}</td>
                <td><span class="badge">{{ pendingCashouts }}</span></td>
            </tr>
            <tr>
                <td>{{ link_to('support/list', 'Number of pending messages') }}</td>
                <td><span class="badge">{{ pendingMessages }}</span></td>
            </tr>
            </tbody>
        </table>


    </div>
</div>