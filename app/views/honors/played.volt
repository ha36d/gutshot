{{ content() }}

<form method="post">

    <h2>Hands Played</h2>

    <div class="well" align="center">

        <div class="clearfix">
            {{ text_field('hands') }}
        </div>
        <div class="clearfix">{{ select('date', ['today': 'Today', 'yesterday':'yesterday', '-1 day':'Last 24 hours', '-2 day':'Last 48 hours', '-3 day':'Last 72 hours', '-1 week':'Last Week'], 'useEmpty': true,
            'emptyText': 'From
            the beginning',
            'emptyValue': '') }}
        </div>
        <div class="clearfix">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </div>
</form>
{% if request.isPost() and winners is defined %}
<div class="center scaffold">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Hands Played</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                {% for winner in winners %}
                {% if loop.first %}
                <table class="table table-condensed table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Player</td>
                        <td>Hands</td>
                    </tr>
                    </thead>
                    {% endif %}
                    <tr>
                        <td>{{ loop.index }}</td>
                        <td>{{ winner.player }}</td>
                        <td>({{ winner.rowcount }})</td>
                    </tr>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% endfor %}
            </div>

        </div>
    </div>
</div>
{% endif %}