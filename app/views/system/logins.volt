{{ content() }}

<form method="post">

    <h2>Logins</h2>

    <div class="well" align="center">

        <div class="clearfix">{{ text_field('ip') }}
        </div>
        <div class="clearfix">{{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </div>
</form>

<div class="center scaffold">
    {% for ip in ips %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>IP Address</th>
            <th>User</th>
            <th>Date</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ip.ipAddress}}</td>
            <td>{{ip.user.player}}</td>
            <td>{{ date("Y-m-d H:i", ip.createdAt) }}</td>
        </tr>
        </tbody>
        {% if loop.last %}
    </table>
    {% endif %}
    {% else %}
    No IP Address.
    {% endfor %}
</div>