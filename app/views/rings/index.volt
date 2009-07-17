{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}
<div class="center scaffold">
    <h2>Ring</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Ring</a></li>
        <li><a href="#B" data-toggle="tab">History</a></li>
    </ul>
    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                <form method="post">
                    <div class="clearfix">
                        <label for="game">Game</label>
                        {{ form.render("game") }}
                    </div>

                    <div class="clearfix">
                        <label for="pw">Password</label>
                        {{ form.render("pw") }}
                    </div>

                    <div class="clearfix">
                        <label for="seats">Seats</label>
                        {{ form.render("seats") }}
                    </div>

                    <div class="clearfix">
                        <label for="plan">Plan</label>
                        {{ form.render("plan") }}
                    </div>

                    <div class="clearfix">
                        <label for="speed">Speed</label>
                        {{ form.render("speed") }}
                    </div>

                    <div class="well">
                        <div class="clearfix">
                            {{ submit_button("Request", "class": "btn btn-big btn-info") }}
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="B">
                {% for ring in page %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Game</th>
                        <th>Seats</th>
                        <th>Minimum buy</th>
                        <th>Maximum buy</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ ring.name }}</td>
                        <td>{{ ring.game }}</td>
                        <td>{{ ring.seats }}</td>
                        <td>{{ ring.minimum_buy_in }}</td>
                        <td>{{ ring.maximum_buy_in }}</td>
                        {% if ring.status == "private" %}
                        <td width="12%">{{ form('rings/cancel/', 'method':'post') ~ hidden_field('id',
                            'value':ring.id) ~ submit_button('Delete Request', 'class':'btn') ~ end_form() }}
                        </td>
                        {% else %}
                        <td width="12%"></td>
                        {% endif %}
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No rings are recorded
                {% endfor %}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').dataTable({
            "order": [[0, 'desc']]
        });
    });
</script>