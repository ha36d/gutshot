{{ content() }}

<form method="post">

    <h2>Level Up</h2>

    <div class="well" align="center">

        <div class="clearfix">
            {{ text_field('xp', 'placeholder':'Experience') }}
        </div>
        <div class="clearfix">
            {{ select('level', ['1':'1', '2':'2', '3':'3', '4':'4', '5':'5', '6':'6', '7':'7', '8':'8', '9':'9',
            '9':'9', '10':'10', '11':'11', '12':'12', '13':'13', '14':'14', '15':'15', '16':'16', '17':'17', '18':'18',
            '19':'19', '20':'20', '21':'21', '22':'22', '23':'23', '24':'24', '25':'25', '26':'26'], 'useEmpty': true, 'emptyText': 'Please select a level', 'emptyValue': '') }}
        </div>
        <div class="clearfix">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </div>
</form>
{% if request.isPost() and winners is defined %}
<div class="center scaffold">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Level Up</a></li>
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
                        <td>Level</td>
                        <td>XP</td>
                    </tr>
                    </thead>
                    {% endif %}
                    <tr>
                        <td>{{ loop.index }}</td>
                        <td>{{ winner.player }}</td>
                        <td>({{ winner.level }})</td>
                        <td>({{ winner.xp }})</td>
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