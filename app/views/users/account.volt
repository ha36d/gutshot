{{ flashSession.output() }}
{{ content() }}
{{ stylesheet_link('css/dataTables.bootstrap.css') }}
{{ javascript_include('js/jquery.dataTables.min.js') }}
{{ javascript_include('js/dataTables.bootstrap.min.js') }}
<div class="center scaffold">
    <h2>My Account</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">My Account</a></li>
        <li><a href="#B" data-toggle="tab">Edit Account</a></li>
        <li><a href="#C" data-toggle="tab">Balance Details</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                <p>
                <table class="table table-bordered table-striped" align="center">
                    <tbody>
                    <tr>
                        <td>Player:</td>
                        <td>{{ userDetails.player }}</td>
                    </tr>
                    <tr>
                        <td>Account Balance:</td>
                        <td> {{ balance }}</td>
                    </tr>
                    <tr>
                        <td>Real Name:</td>
                        <td>{{ userDetails.name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ userDetails.email }}</td>
                    </tr>
                    <tr>
                        <td>Avatar:</td>
                        <td>
                            <div style="display: inline-block; width: 48px; height: 48px; background:url('{{ config.poker_api.avatar_url }}') no-repeat -{{ (userDetails.avatar-1)*48 }}px 0px">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Location:</td>
                        <td>{{ userDetails.location }}</td>
                    </tr>

                    <tr>
                        <td>Gender:</td>
                        <td>{{ userDetails.gender }}</td>
                    </tr>
                    </tbody>
                </table>
                </p>
            </div>

            <div class="tab-pane" id="B">
                <form method="post" autocomplete="off">
                    <div class="row-fluid">
                        <div class="span6">

                            {{ form.render("id") }}
                            <div class="clearfix">
                                <label for="name">Name</label>
                                {{ form.render("name") }}
                            </div>

                            <div class="clearfix">
                                <label for="location">Location</label>
                                {{ form.render("location") }}
                            </div>

                            <div class="clearfix">
                                <label for="location">Gender</label>
                                {{ form.render("gender") }}
                            </div>
                            <div class="clearfix">
                                {% set avatar_url = config.poker_api.avatar_url %}
                                {% set avatar_max = config.poker_api.avatar_max %}
                                {% for i in 1..avatar_max %}
                                <div style="display: inline-block; width: 48px; height: 48px; background:url('{{ avatar_url }}') no-repeat -{{ (i-1)*48 }}px 0px">
                                    {{ form.render("avatar" ~ i) }}
                                </div>
                                {% endfor %}
                            </div>
                        </div>
                        <div class="span6">
                            <div class="clearfix">
                                <label for="card">Card</label>
                                {{ form.render("card") }}
                            </div>

                            <div class="clearfix">
                                <label for="account">Account</label>
                                {{ form.render("account") }}
                            </div>

                            <div class="clearfix">
                                <label for="holder">Holder</label>
                                {{ form.render("holder") }}
                            </div>
                            <div class="clearfix">
                                <label for="bank">Bank</label>
                                {{ form.render("bank") }}
                            </div>
                            <div class="clearfix">
                                <label for="shaba">Shaba</label>
                                {{ form.render("shaba") }}
                            </div>
                        </div>
                    </div>
                    <div class="well">
                        <div class="clearfix">
                            {{ form.render("code") }}
                        </div>
                        {{ submit_button("Save", "class": "btn btn-big btn-info") }}
                        {{ link_to("users/pinResend", "Resend Pin Code", "class": "btn btn-primary") }}
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="C">
                    {% for balancesDetail in balancesDetails %}
                    {% if loop.first %}
                    <table class="table table-bordered table-striped" align="center" id="table">
                        <thead>
                        <tr>
                            <th>Change</th>
                            <th>Balance</th>
                            <th>Source</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% endif %}
                        <tr>
                            <td>{{ balancesDetail.amountChange }}</td>
                            <td>{{ balancesDetail.amountBalance }}</td>
                            <td>{{ balancesDetail.src }}</td>
                            <td>{{ date("Y-m-d H:i:s", balancesDetail.createdAt) }}</td>
                        </tr>
                        {% if loop.last %}
                        </tbody>
                    </table>
                    {% endif %}
                    {% else %}
                    No balance are recorded
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