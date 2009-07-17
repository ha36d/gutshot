{{ flashSession.output() }}
{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("honors/search", "&larr; Search") }}
    </li>
    <li class="pull-right">
        {{ link_to("honors/give", "Give Honor", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Honors</h2>
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
    {% for honor in page.items %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center">
        <thead>
        <tr>
            <th>Player</th>
            <th>Type</th>
            <th>Prize</th>
            <th>Comment</th>
            <th>Date</th>
        </tr>
        </thead>
        {% endif %}
        {% set second = honor.type % 100 %}
        {% set first = (honor.type - second) / 100  %}
        <tbody>
        <tr>
            <td>{{ honor.user.player }}</td>
            <td>{{ type[first] ~ place[second] }}</td>
            <td>{{ honor.prize }}</td>
            <td>{{ honor.comment }}</td>
            <td>{{ date("Y-m-d H:i:s", honor.createdAt) }}</td>
        </tr>
        </tbody>
        {% if loop.last %}
        <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("honors/list", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("honors/list?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous',
                    "class": "btn ") }}
                    {{ link_to("honors/list?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class":
                    "btn") }}
                    {{ link_to("honors/list?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class":
                    "btn") }}
                    <a class="btn disabled"><i class="icon-info-sign"></i> {{ 'Page ' ~ page.current ~ " of " ~ page.total_pages }} </a> }}
                </div>
            </td>
        </tr>
        <tbody>
    </table>
    {% endif %}
    {% else %}
    No honors are recorded
    {% endfor %}
</div>