{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}
<div class="center scaffold">
    <h2>Rake Back</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Rake Back</a></li>
        <li><a href="#B" data-toggle="tab">History</a></li>
        <li><a href="#C" data-toggle="tab">Invite</a></li>
    </ul>
    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                {% for rake in rakes %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Amount</th>
                        <th>Operations</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ rake.email}}</td>
                        <td>{{ rake.amounts }}</td>
                        <td width="12%">{{ form('rakes/done/', 'method':'post') ~ hidden_field('id', 'value':rake.fromId) ~ submit_button('Get Rake', 'class':'btn') ~ end_form() }}
                        </td>
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No rakes are recorded
                {% endfor %}
            </div>
            <div class="tab-pane" id="B">
                {% for rake in rakes_accepted %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table_accpeted">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ rake.email}}</td>
                        <td>{{ rake.total }}</td>
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No rakes are recorded
                {% endfor %}
            </div>

            <div class="tab-pane" id="C">
                <form method="post" autocomplete="off">

                    <div class="clearfix">
                        <label for="email">E-mail</label>
                        {{ form.render("email") }}
                    </div>
                    {{ submit_button("Send", "class": "btn btn-primary") }}

                </form>

                {% for invitation in invitations %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center", id="invitations">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Confirmed</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ invitation.email }}</td>
                        <td>{{ date("Y-m-d H:i", invitation.createdAt) }}</td>
                        <td>{{ invitation.confirmed }}</td>
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No invitations are recorded
                {% endfor %}
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table, #table_accpeted, #invitations').dataTable({
            "order": [[1, 'desc']]
        });
    });
</script>