{{ content() }}

<h2>Connections</h2>

<div class="center scaffold">
    {% for Session in connections.SessionID %}
    {% set number = loop.index0 %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>SessionID</th>
            <th>Status</th>
            <th>Player</th>
            <th>PC</th>
            <th>IP</th>
            <th>Connect</th>
            <th>Login</th>
            <th>LastAction</th>
            <th>PacketsIn</th>
            <th>PacketsOut</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{connections.SessionID[number]}}</td>
            <td>{{connections.Status[number]}}</td>
            <td>{{connections.Player[number]}}</td>
            <td>{{connections.PC[number]}}</td>
            <td>{{connections.IP[number]}}</td>
            <td>{{connections.Connect[number]}}</td>
            <td>{{connections.Login[number]}}</td>
            <td>{{connections.LastAction[number]}}</td>
            <td>{{connections.PacketsIn[number]}}</td>
            <td>{{connections.PacketsOut[number]}}</td>
        </tr>
        </tbody>
        {% if loop.last %}
    </table>
    {% endif %}
    {% else %}
    No Active User.
    {% endfor %}
</div>