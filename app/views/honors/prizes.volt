{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}
<div class="center scaffold">
    <h2>Level Up Prizes</h2>
    {% set champs_value = {
    '811' : '300',
    '812' : '500',
    '813' : '800',
    '814' : '1200',
    '815' : '1700',
    '816' : '2500',
    '817' : '5000',
    '818' : '8000',
    '819' : '13000',
    '820' : '20000',
    '821' : '32000',
    '822' : '55000',
    '823' : '90000',
    '824' : '150000',
    '825' : '240000',
    '826' : '380000',
    '827' : '700000',
    '828' : '1100000',
    '829' : '1800000',
    '830' : '2800000',
    '831' : '4600000',
    '832' : '8000000',
    '833' : '15000000',
    '834' : '25000000',
    '835' : '40000000'} %}

    {% for prize in prizes %}
    {% if loop.first %}
    <table class="table table-bordered table-striped" align="center" id="table">
        <thead>
        <tr>
            <th>Level</th>
            <th>Prize</th>
            <th>Operations</th>
        </tr>
        </thead>
        <tbody>
        {% endif %}
        <tr>
            <td>{{ prize['type'] - 810 }}</td>
            <td>{{ champs_value[prize['type']] }}</td>
            <td width="12%">
                {% if prize['done'] == 'no' %}
                Prize Got
                {% else %}
                {{ form('honors/done/', 'method':'post') ~ hidden_field('id', 'value':prize['type'] ) ~
                submit_button('Get Prize', 'class':'btn') ~ end_form() }}
                {% endif %}
            </td>
        </tr>
        {% if loop.last %}
        </tbody>
    </table>
    {% endif %}
    {% else %}
    No prizes are recorded
    {% endfor %}
</div>
<script>
    $(document).ready(function () {
        $('#table, #table_accpeted, #invitations').dataTable({
            "order": [[0, 'asc']]
        });
    });
</script>