{{ flashSession.output() }}
{{ content() }}
{% if logged_in is empty %}
<header class="jumbotron subhead" id="overview">
    <div class="hero-unit">
        <h1>Welcome!</h1>

        <p class="lead">to Gutshot Club!</p>

        <div align="right">
            {{ link_to('session/signup', '<i class="icon-ok icon-white"></i> Create an Account', 'class': 'btn
            btn-primary btn-large') }}
        </div>
    </div>
</header>
{% else %}
<div id="myCarousel" class="carousel slide">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Carousel items -->
    <div class="carousel-inner">
        <div class="active item">
            <img src="http://{{ publicUrl }}/img/carousel-1.jpg" alt="">

            <div class="carousel-caption">
                <h4>{{ link_to("articles/prize", "Prizes") }}</h4>
            </div>
        </div>
        <div class="item">
            <img src="http://{{ publicUrl }}/img/carousel-2.jpg" alt="">

            <div class="carousel-caption">
                <h4>{{ link_to("articles/instruction", "Instructions") }}</h4>
            </div>
        </div>
        <div class="item">
            <img src="http://{{ publicUrl }}/img/carousel-3.jpg" alt="">

            <div class="carousel-caption">
                <h4>{{ link_to("articles/news", "News") }}</h4>
            </div>
        </div>
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
{% endif %}
{% if logged_in is not empty %}
<div class="container-fluid">
    <div class="row-fluid">

        <div class="span2">
            <img src="http://{{ publicUrl }}img/logo.png" height="120" width="120" alt="">
            <hr>
            <address>
                <strong>Gutshot, Inc.</strong><br>
                <a href="https://instagram.com/gutshot.club">Gutshot Instagram</a>
                <br>
                <a href="https://telegram.org/gutshot.club">Gutshot Telegram</a>
            </address>
            <address>
                <strong>Email:</strong><br>
                <a href="mailto:supp@gutshot.club">supp@gutshot.club</a>
            </address>
        </div>

        <div class="span10">
            <div id="TourneyCarousel" class="carousel slide">
                <ol class="carousel-indicators">
                    {% set counter = 0 %}
                    {% for tournament in tourney.Name %}
                    {% set index = loop.index0 %}
                    {% if tourney.Status[index] != 'Offline' %}
                    {% if counter == 0 %}
                    <li data-target="#TourneyCarousel" data-slide-to="{{ counter }}" class="active"></li>
                    {% else %}
                    <li data-target="#TourneyCarousel" data-slide-to="{{ counter }}"></li>
                    {% endif %}
                    {% set counter = counter + 1 %}
                    {% endif %}
                    {% endfor %}
                </ol>
                <!-- Carousel items -->
                <div class="carousel-inner">
                    {% set counter = 0 %}
                    {% for tournament in tourney.Name %}
                    {% set index = loop.index0 %}
                    {% if tourney.Status[index] != 'Offline' %}
                    {% if counter == 0 %}
                    <div class="active item">
                        {% else %}
                        <div class="item">
                            {% endif %}
                            <img src="http://{{ publicUrl }}img/tournament-{{index % 3}}.png" alt="">

                            <div class="carousel-caption">
                                <h4>{{ tourney.Name[index] }}</h4>
                                <small>
                                    <table class="table table-condensed border-less " align="center">
                                        <tr>
                                            <td>{{ tourney.Game[index] }}</td>
                                            <td>{{ tourney.Status[index] }}</td>
                                            <td>Fee: {{ tourney.EntryFee[index] }}</td>
                                            <td>Prize: {{ tourney.PrizeBonus[index] }}</td>
                                            <td></td>

                                        </tr>
                                        <tr>
                                            <td>{{ tourney.StartTime[index] }}</td>
                                            <td>Max Rebuys: {{ tourney.MaxRebuys[index] }}</td>
                                            <td>Rebuy Fee: {{ tourney.RebuyFee[index] }}</td>
                                            <td>Payout: {{ tourney.Payout[index] }}</td>
                                            <td>
                                                {% if tourney.RegisterStatus[index] == 'registered' %}
                                                {{ form('tourneys/unregister/', 'method':'post') ~ hidden_field('name',
                                                'value':tourney.Name[index]) ~ submit_button('Unregister',
                                                'class':'btn') ~
                                                end_form() }}
                                                {% else %}
                                                {{ form('tourneys/register/', 'method':'post') ~ hidden_field('name',
                                                'value':tourney.Name[index]) ~ submit_button('Register', 'class':'btn')
                                                ~
                                                end_form() }}
                                                {% endif %}
                                            </td>
                                        </tr>
                                    </table>
                                </small>
                            </div>
                        </div>
                        {% set counter = counter + 1 %}
                        {% endif %}
                        {% else %}
                        No Tournament player are recorded
                        {% endfor %}

                    </div>
                    <!-- Carousel nav -->
                    <a class="carousel-control left" href="#TourneyCarousel" data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" href="#TourneyCarousel" data-slide="next">&rsaquo;</a>
                </div>
            </div>

        </div>
    </div>
    {% endif %}