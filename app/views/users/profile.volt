{{ content() }}

<form method="get">

    <h2>Profile</h2>

    <div class="well" align="center">

        <div class="clearfix">
            {{ text_field('Player', 'data-provide' : 'typeahead',
            'autocomplete' : 'off',
            'placeholder' : 'Player',
            'data-source' : Users,
            'data-items' : 3,
            'data-min-length' : 3) }}
        </div>
        <div class="clearfix">
            {{ submit_button('Search', 'class': 'btn btn-primary') }}
        </div>
    </div>
</form>
{% if profile is not empty %}

{% set champs_value = {
'111' : '15000',
'112' : '10000',
'113' : '7000',
'114' : '5000',
'115' : '4000',
'116' : '3500',
'117' : '3000',
'118' : '2500',
'119' : '2000',
'120' : '1500',
'121' : '1250',
'122' : '1000',
'123' : '750',
'124' : '750',
'125' : '750',
'126' : '500',
'127' : '500',
'128' : '500',
'129' : '250',
'130' : '250',
'211' : '5000',
'212' : '3000',
'213' : '2000',
'214' : '1500',
'215' : '1000',
'216' : '1000',
'217' : '750',
'218' : '750',
'219' : '750',
'220' : '750',
'221' : '500',
'222' : '500',
'223' : '500',
'224' : '500',
'225' : '250',
'226' : '250',
'227' : '250',
'228' : '250',
'229' : '250',
'230' : '250',
'311' : '10000',
'312' : '7000',
'313' : '5000',
'314' : '3500',
'315' : '2500',
'316' : '2000',
'317' : '1750',
'318' : '1500',
'319' : '1250',
'320' : '1000',
'321' : '750',
'322' : '750',
'323' : '500',
'324' : '500',
'325' : '500',
'326' : '500',
'327' : '250',
'328' : '250',
'329' : '250',
'330' : '250',
'411' : '15000',
'412' : '10000',
'413' : '7000',
'414' : '5000',
'415' : '4000',
'416' : '3500',
'417' : '3000',
'418' : '2500',
'419' : '2000',
'420' : '1500',
'421' : '1250',
'422' : '1000',
'423' : '750',
'424' : '750',
'425' : '750',
'426' : '500',
'427' : '500',
'428' : '500',
'429' : '250',
'430' : '250',
'511' : '5000',
'512' : '3000',
'513' : '2000',
'514' : '1500',
'515' : '1000',
'516' : '1000',
'517' : '750',
'518' : '750',
'519' : '750',
'520' : '750',
'521' : '500',
'522' : '500',
'523' : '500',
'524' : '500',
'525' : '250',
'526' : '250',
'527' : '250',
'528' : '250',
'529' : '250',
'530' : '250',
'611' : '2000',
'612' : '1500',
'613' : '1250',
'614' : '1000',
'615' : '800',
'616' : '650',
'617' : '500',
'618' : '400',
'619' : '350',
'620' : '300',
'621' : '250',
'622' : '200',
'623' : '175',
'624' : '150',
'625' : '125',
'626' : '100',
'627' : '100',
'628' : '75',
'629' : '50',
'630' : '25',
'711' : '500000',
'712' : '200000',
'713' : '100000',
'714' : '50000',
'715' : '25000',
'716' : '20000',
'717' : '15000',
'718' : '10000',
'719' : '7000',
'720' : '5000',
'721' : '3000',
'722' : '2000',
'723' : '1500',
'724' : '1000',
'725' : '750',
'726' : '500',
'727' : '250',
'728' : '200',
'729' : '100',
'730' : '50',
'811' : '0',
'812' : '0',
'813' : '0',
'814' : '0',
'815' : '0',
'816' : '0',
'817' : '0',
'818' : '0',
'819' : '0',
'820' : '0',
'821' : '0',
'822' : '0',
'823' : '0',
'824' : '0',
'825' : '0',
'826' : '0',
'827' : '0',
'828' : '0',
'829' : '0',
'830' : '0'} %}
{{ stylesheet_link('css/flaticon/flaticon.css') }}

<div class="center scaffold">
    <div>
        <ul class="thumbnails">
            <li class="span4">
                <div class="thumbnail">
                    <div style="display: inline-block; width: 48px; height: 48px; background:url('{{ config.poker_api.avatar_url }}') no-repeat -{{ (profile.avatar-1)*48 }}px 0px">
                    </div>

                    <h3>{{ profile.player }}</h3>

                    <p>
                    <ul>
                        <li>
                            <strong>
                                Name: {{ profile.name }}
                            </strong>
                        </li>
                        <li>
                            <strong>
                                Gender: {{ profile.gender }}
                            </strong>
                        </li>
                        <li>
                            <strong>
                                Location: {{ profile.location }}
                            </strong>
                        </li>
                    </ul>
                    </p>
                    <br>
                    <br>
                    <br>
                </div>
            </li>
            <li class="span4">
                <div class="thumbnail">
                    <img height="150" width="150" src="http://{{ publicUrl }}/img/chip.png" class="img-circle">

                    <h3>Level/XP:</h3>

                    <ul>
                        <li>
                            <strong>
                                Level:
                                <span>{{ profile.level }}</span>
                            </strong>
                        </li>
                        <li>
                            <strong>
                                Experience: {{ profile.xp }}
                            </strong>

                            <div class="progress progress-striped active">
                                <div class="bar" style="width: {{ profile.xp / 100000 }}%;"></div>
                            </div>
                        </li>
                    </ul>

                </div>
            </li>
            <li class="span4">
                <div class="thumbnail">
                    <img height="85" width="80" src="http://{{ publicUrl }}/img/hand.png" class="img-circle">

                    <h3>Best Hands:</h3>

                    <p>
                        {% for best_hand in best_hand_win %}
                        {% if loop.first %}
                    <ul>
                        {% endif %}
                        <li>
                            <small> ({{ best_hand.hand }})</small>
                        </li>
                        {% if loop.last %}
                    </ul>
                    {% endif %}
                    {% endfor %}
                    </p>
                </div>
            </li>
        </ul>
    </div>
    {% set type = [
    '1' : 'Most Hands Played of the Week',
    '2' : 'Most Hands Won of the Week',
    '3' : 'Biggest Pots Won of the Week',
    '4' : 'Most Chips Won of the Week',
    '5' : 'Best Winning Hands of the Week',
    '6' : 'Tournament',
    '7' : 'Other',
    '8' : 'LevelUp'] %}

    {% set place = [
    '11' : '(1st place)',
    '12' : '(2nd place)',
    '13' : '(3rd place)',
    '14' : '(4th place)',
    '15' : '(5th place)',
    '16' : '(6th place)',
    '17' : '(7th place)',
    '18' : '(8th place)',
    '19' : '(9th place)',
    '20' : '(10th place)',
    '21' : '(11th place)',
    '22' : '(12th place)',
    '23' : '(13th place)',
    '24' : '(14th place)',
    '25' : '(15th place)',
    '26' : '(16th place)',
    '27' : '(17th place)',
    '28' : '(18th place)',
    '29' : '(19th place)',
    '30' : '(20th place)'] %}
    <div>
        <h3>Medals:</h3>
        {% for honor in profile.honors %}
        {% if loop.first %}
        <ul class="thumbnails">
            {% endif %}
            {% set second = honor.type % 100 %}
            {% set first = (honor.type - second) / 100 %}
            {% if second > 15 %}
            {% set icon = first ~ '15' %}
            {% else %}
            {% set icon = honor.type %}
            {% endif %}
            <li>
                <div class="thumbnail">
                    <img data-src="holder.js/200x200?random=yes&text={{ type[first] ~ ' ' ~ place[second] }}"
                         class="img-circle">
                    {{"<span class='flaticon-trophy" ~ icon ~ "'></span>"}}
                    <div class="caption">
                        <p>
                        <div class="clearfix">
                            Prize: {{ honor.prize }}
                        </div>
                        <div class="clearfix">
                            XP: {{ champs_value[honor.type] }}
                        </div>
                        <div class="clearfix">
                            Date: {{ date("d M H:i", honor.createdAt) }}
                        </div>

                    </div>
                </div>
            </li>
            {% if loop.last %}
        </ul>
        {% endif %}
        {% else %}
        No Honors are recorded
        {% endfor %}
    </div>
</div>
{% endif %}