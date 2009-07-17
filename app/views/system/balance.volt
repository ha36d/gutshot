{{ content() }}

<form method="post">

    <h2>Balance</h2>

    <div class="well" align="center">

        <div class="clearfix">{{ select('usersId', users, 'using': ['id', 'player'], 'useEmpty': true, 'emptyText':
            'Select a
            User',
            'emptyValue': '') }}
        </div>
        <div class="clearfix">{{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </div>
</form>

<div class="center scaffold">
    {% if balances.Error is not empty %}
    {{ balances.Error }}
    {% elseif balances.Accounts is not empty %}
    {% for player in balances.Player %}
    {% set index = loop.index0 %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Balance</th>
            <th>RingChips</th>
            <th>RegChips</th>
        </tr>
        </thead>
        {% endif %}
        <tbody>
        <tr>
            <td>{{ balances.Player[index] }}</td>
            <td>{{ balances.Balance[index] }}</td>
            <td>{{ balances.RingChips[index] }}</td>
            <td>{{ balances.RegChips[index] }}</td>
        </tr>
        </tbody>
        {% if loop.last %}
    </table>
    {% endif %}
    {% else %}
    No IP Address.
    {% endfor %}
    {% else %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Balance</th>
            <th>RingChips</th>
            <th>RegChips</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ balances.Player }}</td>
            <td>{{ balances.Balance }}</td>
            <td>{{ balances.RingChips }}</td>
            <td>{{ balances.RegChips }}</td>
        </tr>
        </tbody>
    </table>
    {% endif %}
</div>