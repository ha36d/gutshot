{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}

<div class="center scaffold">
    <h2>Transfer</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Transfer</a></li>
        <li><a href="#B" data-toggle="tab">History</a></li>
    </ul>
    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                <form method="post">
                    <div class="clearfix">
                        <label for="amount">Amount</label>
                        {{ form.render("amount") }}
                    </div>
                    <div class="clearfix">
                        <label for="usersId">Player</label>
                        {{ form.render("usersId") }}
                    </div>
                    <div class="well">
                        <div class="clearfix">
                            {{ form.render("code") }}
                        </div>
                        {{ submit_button("Transfer", "class": "btn btn-big btn-info") }}
                        {{ link_to("users/pinResend", "Resend Pin Code", "class": "btn btn-primary") }}
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="B">
                {% for transfer in page %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table">
                    <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ transfer.userOut.player }}</td>
                        <td>{{ transfer.userIn.player }}</td>
                        <td>{{ transfer.amount }}</td>
                        <td>{{ date("Y-m-d H:i", transfer.createdAt) }}</td>
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No transfers are recorded
                {% endfor %}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table').dataTable({
            "order": [[3, 'desc']]
        });
    });
</script>