<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            {{ link_to(null, 'class': 'brand', 'Gutshot')}}
            <div class="nav-collapse collapse">
                <ul class="nav">
                    {% for controller, value in menus %}
                    {% if value is not scalar %}
                    {% if controller == dispatcher.getControllerName() %}
                    <li class="dropdown active">
                        {% else %}
                    <li class="dropdown">
                        {% endif %}
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ controller|capitalize }}</a>
                        <ul class="dropdown-menu">
                            {% for key, action in value %}
                            {% set link = controller ~ "/" ~ action %}
                            <li> {{ link_to(link, action|capitalize) }}</li>
                            {% endfor %}
                        </ul>
                    </li>
                    {% else %}
                    {% if controller == dispatcher.getControllerName() %}
                    <li class="active">{{ link_to(controller ~ "/" ~ value, controller|capitalize) }}</li>
                    {% else %}
                    <li>{{ link_to(controller ~ "/" ~ value, controller|capitalize) }}</li>
                    {% endif %}
                    {% endif %}

                    {% endfor %}
                </ul>

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ auth.getName() }} <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('users/changePassword', 'Change Password') }}</li>
                            <li>{{ link_to('users/account', 'My Account') }}</li>
                            <li>{{ link_to('users/profile?Player=' ~ auth.getPlayer(), 'My Profile') }}</li>
                            <li>{{ link_to('session/logout', 'Logout') }}</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span10">

            {{ content() }}

        </div>
        <div class="span2">
            <div class="tabbable">
                <ul id="dataTab" class="nav nav-tabs">
                    <li class="active"><a href="#chips" data-toggle="tab">Chips</a>
                    </li>
                    <li><a href="#stats" data-toggle="tab">Stats</a>
                    </li>
                    <li><a href="#xp" data-toggle="tab">XP</a>
                    </li>
                </ul>
                <div id="dataTabContent" class="tab-content">
                    <div class="tab-pane active" id="chips">
                        <p>
                        <ul>
                            {% if chips.error is empty %}
                            <li>
                                Balance: {{ chips.Balance }}
                            </li>
                            <li>
                                Ring: {{ chips.RingChips }}
                            </li>
                            <li>
                                Tournament: {{ chips.RegChips }}
                            </li>
                            <li>
                                Total: {{ chips.RingChips+chips.RegChips+chips.Balance }}
                            </li>
                            {% endif %}
                        </ul>
                        </p>
                    </div>
                    <div class="tab-pane" id="stats">
                        <p>
                        <ul>
                            {% if stats.error is empty %}
                            <li>
                                Online Players: {{ stats.Logins }}
                            </li>
                            <li>
                                Filled Seats: {{ stats.FilledSeats }}
                            </li>
                            <li>
                                Occupied Tables: {{ stats.OccupiedTables }}
                            </li>
                            <li>
                                {{ stats.LocalTime }}
                            </li>
                            {% endif %}
                        </ul>
                        </p>
                    </div>
                    <div class="tab-pane" id="xp">
                        <p>
                        <ul>
                            <li>
                                Experience: {{ user.xp }}
                            </li>
                            <li>
                                Level: {{ user.level }}
                            </li>
                            <li>
                                Rake: {{ user.rake * 2 }}%
                            </li>
                            <li>
                                Hands: {{ number_played }} ({{ number_pot_win }} won)
                            </li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="tabbable">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="dropdown">
                        <a class="dropdown-toggle"
                           data-toggle="dropdown"
                           href="#" id="ChampionLink">
                            Champions of Week
                            <b class="caret"></b>
                        </a>
                        <ul id="Champions" class="dropdown-menu">
                            <li><a href="#most_hands_played" data-toggle="tab">Most Hands Played</a></li>
                            <li><a href="#most_hands_winners" data-toggle="tab">Most Hands Won</a></li>
                            <li><a href="#most_pot_winners" data-toggle="tab">Biggest Pots Won</a></li>
                            <li><a href="#cheap_leaders" data-toggle="tab">Most Chips Won</a></li>
                            <li><a href="#best_hand_winners" data-toggle="tab">Best Winning Hands</a></li>

                        </ul>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">

                    <div class="tab-pane fade" id="most_hands_played">
                        <div class="chart-body">
                            Most Hands Played:
                            {% for most_hand_played in most_hands_played %}
                            {% if loop.first %}
                            <table class="table table-condensed border-less">
                                {% endif %}
                                <tr>
                                    {% if loop.index0 < 20 %}
                                    <td><b>{{ loop.index }}</b></td>
                                    <td><b>{{ most_hand_played.player }}</b></td>
                                    <td><b>({{ most_hand_played.rowcount }})</b></td>
                                    {% else %}
                                    <td>{{ loop.index }}</td>
                                    <td>{{ most_hand_played.player }}</td>
                                    <td>({{ most_hand_played.rowcount }})</td>
                                    {% endif %}
                                </tr>
                                {% if loop.last %}
                            </table>
                            {% endif %}
                            {% endfor %}
                        </div>
                        <hr>
                        Your Tally:
                        <ul>
                            <li>{{ my_most_hands_played }}</li>
                        </ul>
                    </div>

                    <div class="tab-pane fade" id="most_hands_winners">
                        <div class="chart-body">
                            Most Hands Won:
                            {% for most_hands_winner in most_hands_winners %}
                            {% if loop.first %}
                            <table class="table table-condensed border-less">
                                {% endif %}
                                <tr>
                                    {% if loop.index0 < 20 %}
                                    <td><b>{{ loop.index }}</b></td>
                                    <td><b>{{ most_hands_winner.player }}</b></td>
                                    <td><b>({{ most_hands_winner.rowcount }})</b></td>
                                    {% else %}
                                    <td>{{ loop.index }}</td>
                                    <td>{{ most_hands_winner.player }}</td>
                                    <td>({{ most_hands_winner.rowcount }})</td>
                                    {% endif %}
                                </tr>
                                {% if loop.last %}
                            </table>
                            {% endif %}
                            {% endfor %}
                        </div>
                        <hr>
                        Your Tally:
                        <ul>
                            <li>{{ my_most_hands_winners }}</li>
                        </ul>
                    </div>

                    <div class="tab-pane fade" id="most_pot_winners">
                        <div class="chart-body">
                            Biggest Pots Won:
                            {% for most_pot_winner in most_pot_winners %}
                            {% if loop.first %}
                            <table class="table table-condensed border-less">
                                {% endif %}
                                <tr>
                                    {% if loop.index0 < 20 %}
                                    <td><b>{{ loop.index }}</b></td>
                                    <td><b>{{ most_pot_winner.player }}</b></td>
                                    <td><b>({{ most_pot_winner.amount }})</b></td>
                                    {% else %}
                                    <td>{{ loop.index }}</td>
                                    <td>{{ most_pot_winner.player }}</td>
                                    <td>({{ most_pot_winner.amount }})</td>
                                    {% endif %}
                                </tr>
                                {% if loop.last %}
                            </table>
                            {% endif %}
                            {% endfor %}
                        </div>
                        <hr>
                        Your Best Pots:
                        {% for my_most_pot_winner in my_most_pot_winners %}
                        {% if loop.first %}
                        <table class="table table-condensed border-less">
                            {% endif %}
                            <tr>
                                <td>
                                    <b>{{ my_most_pot_winner.amount }}</b>
                                </td>
                            </tr>
                            {% if loop.last %}
                        </table>
                        {% endif %}
                        {% endfor %}
                    </div>

                    <div class="tab-pane fade" id="cheap_leaders">
                        <div class="chart-body">
                            Most Chips Won:
                            {% for cheap_leader in cheap_leaders %}
                            {% if loop.first %}
                            <table class="table table-condensed border-less">
                                {% endif %}
                                <tr>
                                    {% if loop.index0 < 20 %}
                                    <td><b>{{ loop.index }}</b></td>
                                    <td><b>{{ cheap_leader.player }}</b></td>
                                    <td><b>({{ cheap_leader.sumatory }})</b></td>
                                    {% else %}
                                    <td>{{ loop.index }}</td>
                                    <td>{{ cheap_leader.player }}</td>
                                    <td>({{ cheap_leader.sumatory }})</td>
                                    {% endif %}
                                <tr>
                                    {% if loop.last %}
                            </table>
                            {% endif %}
                            {% endfor %}
                        </div>
                        <hr>
                        Your Tally:
                        <ul>
                            {% if my_cheap_leaders is not empty %}
                            <li>{{ my_cheap_leaders }}</li>
                            {% else %}
                            <li>0</li>
                            {% endif %}
                        </ul>
                    </div>

                    <div class="tab-pane fade" id="best_hand_winners">
                        <div class="chart-body">
                            Best Winning Hands:
                            {% for best_hand_winner in best_hand_winners %}
                            {% if loop.first %}
                            <table class="table table-condensed border-less">
                                {% endif %}
                                <tr>
                                    {% if loop.index0 < 20 %}
                                    <td><b>{{ loop.index }}</b></td>
                                    <td><b>{{ best_hand_winner.player }}</b>
                                        <small>({{ best_hand_winner.hand }})</small>
                                    </td>
                                    {% else %}
                                    <td>{{ loop.index }}</td>
                                    <td>{{ best_hand_winner.player }}
                                        <small> ({{ best_hand_winner.hand }})</small>
                                    </td>
                                    {% endif %}
                                </tr>
                                {% if loop.last %}
                            </table>
                            {% endif %}
                            {% endfor %}
                        </div>
                        <hr>
                        Your Best Winning Hands:
                        {% for my_best_hand_winner in my_best_hand_winners %}
                        {% if loop.first %}
                        <table class="table table-condensed border-less">
                            {% endif %}
                            <tr>
                                <td>
                                    <small>{{ my_best_hand_winner.hand }}</small>
                                </td>
                            </tr>
                            {% if loop.last %}
                        </table>
                        {% endif %}
                        {% endfor %}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var nice = $(".chart-body").niceScroll();  // The document page (body)
    });
</script>