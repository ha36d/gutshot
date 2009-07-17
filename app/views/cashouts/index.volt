{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}

<div class="center scaffold">
    <h2>Cash Out</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Cash Out</a></li>
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
                    <div class="well">
                        <div class="clearfix">
                            {{ submit_button("Cash Out", "class": "btn btn-info") }}
                        </div>
                    </div>

                </form>
            </div>

            <div class="tab-pane" id="B">
                {% for cashout in page %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table">
                    <thead>
                    <tr>
                        <th>Card</th>
                        <th>Account</th>
                        <th>Holder</th>
                        <th>Bank</th>
                        <th>Shaba</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status?</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ cashout.card }}</td>
                        <td>{{ cashout.account }}</td>
                        <td>{{ cashout.holder }}</td>
                        <td>{{ cashout.bank }}</td>
                        <td>{{ cashout.shaba }}</td>
                        <td>{{ cashout.amount }}</td>
                        <td>{{ date("d M Y H:i",cashout.createdAt) }}</td>
                        {% if cashout.status == 'Yes' %}
                        <td>Paid at {{ date("d M Y H:i",cashout.paidAt) }}</td>
                        {% elseif cashout.status == 'No' %}
                        <td>
                           {{ form('cashouts/cancel/', 'method':'post') ~ hidden_field('id', 'value':cashout.id) ~ submit_button('Cancel', 'class':'btn') ~ end_form() }}
                        </td>
                        {% elseif cashout.status == 'Cancel' %}
                        <td>Canceled by User</td>
                        {% else %}
                        <td>The request is rejected by Admin</td>
                        {% endif %}
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No cashouts are recorded
                {% endfor %}
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#table').dataTable({
            "order": [[6, 'desc']]
        });
    });
</script>