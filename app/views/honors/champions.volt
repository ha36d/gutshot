{{ content() }}

<form method="post">

    <h2>Champions</h2>

    <div class="well" align="center">

        <div class="clearfix">{{ select('date', ['-1':'This Week', '-2':'Last Week', '-3':'2 weeks Ago', '-4':'3 weeks
            Ago', '-5':'4 weeks Ago', '-6':'5 weeks Ago','-7':'6 weeks Ago', '-8':'7 weeks Ago',
            '-9':'8 weeks Ago', '-10':'9 weeks Ago'], 'useEmpty': true,
            'emptyText': 'From
            the beginning',
            'emptyValue': '') }}
        </div>
        <div class="clearfix">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>

    </div>
</form>
{% if request.isPost() and most_hands_played is not null %}
<div class="center scaffold">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Most Hands Played</a></li>
        <li><a href="#B" data-toggle="tab">Most Hands Won</a></li>
        <li><a href="#C" data-toggle="tab">Biggest Pots Won</a></li>
        <li><a href="#D" data-toggle="tab">Most Chips Won</a></li>
        <li><a href="#E" data-toggle="tab">Best Winning Hands</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                {% for champ_most_hand_played in champ_most_hands_played %}
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
                        {% if loop.index0 < 20 %}
                        <td><b>{{ loop.index }}</b></td>
                        <td><b>{{ champ_most_hand_played.player }}</b></td>
                        <td><b>({{ champ_most_hand_played.rowcount }})</b></td>
                        {% else %}
                        <td>{{ loop.index }}</td>
                        <td>{{ champ_most_hand_played.player }}</td>
                        <td>({{ champ_most_hand_played.rowcount }})</td>
                        {% endif %}
                    </tr>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% endfor %}
            </div>

            <div class="tab-pane" id="B">
                {% for champ_most_hands_winner in champ_most_hands_winners %}
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
                        {% if loop.index0 < 20 %}
                        <td><b>{{ loop.index }}</b></td>
                        <td><b>{{ champ_most_hands_winner.player }}</b></td>
                        <td><b>({{ champ_most_hands_winner.rowcount }})</b></td>
                        {% else %}
                        <td>{{ loop.index }}</td>
                        <td>{{ champ_most_hands_winner.player }}</td>
                        <td>({{ champ_most_hands_winner.rowcount }})</td>
                        {% endif %}
                    </tr>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% endfor %}
            </div>

            <div class="tab-pane" id="C">
                {% for champ_most_pot_winner in champ_most_pot_winners %}
                {% if loop.first %}
                <table class="table table-condensed table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Player</td>
                        <td>Amount</td>
                    </tr>
                    </thead>
                    {% endif %}
                    <tr>
                        {% if loop.index0 < 20 %}
                        <td><b>{{ loop.index }}</b></td>
                        <td><b>{{ champ_most_pot_winner.player }}</b></td>
                        <td><b>({{ champ_most_pot_winner.amount }})</b></td>
                        {% else %}
                        <td>{{ loop.index }}</td>
                        <td>{{ champ_most_pot_winner.player }}</td>
                        <td>({{ champ_most_pot_winner.amount }})</td>
                        {% endif %}
                    </tr>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% endfor %}
            </div>

            <div class="tab-pane" id="D">
                {% for champ_cheap_leader in champ_cheap_leaders %}
                {% if loop.first %}
                <table class="table table-condensed table-bordered">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Player</td>
                        <td>Amount</td>
                    </tr>
                    </thead>
                    {% endif %}
                    <tr>
                        {% if loop.index0 < 20 %}
                        <td><b>{{ loop.index }}</b></td>
                        <td><b>{{ champ_cheap_leader.player }}</b></td>
                        <td><b>({{ champ_cheap_leader.sumatory }})</b></td>
                        {% else %}
                        <td>{{ loop.index }}</td>
                        <td>{{ champ_cheap_leader.player }}</td>
                        <td>({{ champ_cheap_leader.sumatory }})</td>
                        {% endif %}
                    <tr>
                        {% if loop.last %}
                </table>
                {% endif %}
                {% endfor %}
            </div>

            <div class="tab-pane" id="E">
                {% for champ_best_hand_winner in champ_best_hand_winners %}
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
                        {% if loop.index0 < 20 %}
                        <td><b> {{ loop.index }} </b></td>
                        <td><b>{{ champ_best_hand_winner.player }}</b></td>
                        {% else %}
                        <td> {{ loop.index }}</td>
                        <td>{{ champ_best_hand_winner.player }}</td>
                        {% endif %}
                        <td> ({{ champ_best_hand_winner.hand }})</td>
                        <td>{{ champ_best_hand_winner.amount }}</td>
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