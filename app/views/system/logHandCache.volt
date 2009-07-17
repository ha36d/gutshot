{{ content() }}

<form method="post">

    <h2>Hand History Cache (Last 100 Hands)</h2>

    <div class="well" align="center">

        <div class="clearfix">
            {{ text_field('hand') }}
        </div>
        <div class="clearfix">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>

<div class="center scaffold">
    {% if request.isPost() %}
    {% if events is defined %}
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Hand History</a></li>
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
                No hand histories are recorded
                {% endfor %}

            </div>
        </div>
    </div>
    {% elseif error is defined %}

    {{ error }}

    {% endif %}
    {% endif %}
</div>