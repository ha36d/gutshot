{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}
<div class="center scaffold">
    <h2>Deposit</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Deposit</a></li>
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
                            {{ submit_button("Add Balance", "class": "btn btn-info") }}
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="B">
                {% for deposit in page %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center" id="table">
                    <thead>
                    <tr>
                        <th>Aomunt</th>
                        <th>Date</th>
                        <th>Reference</th>
                        <th>Status?</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% endif %}
                    <tr>
                        <td>{{ deposit.amount }}</td>
                        <td>{{ date("d M Y H:i",deposit.createdAt) }}</td>
                        <td>{{ deposit.ref }}</td>
                        <td>{{ deposit.status == 'Yes' ? 'Success' : 'Failed' }}</td>
                    </tr>
                    {% if loop.last %}
                    </tbody>
                </table>
                {% endif %}
                {% else %}
                No deposits are recorded
                {% endfor %}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table').dataTable({
            "order": [[1, 'desc']]
        });
    });
</script>