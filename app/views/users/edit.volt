{{ flashSession.output() }}
{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("users/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Save", "class": "btn btn-big btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Edit Users</h2>

        <ul class="nav nav-tabs">
            <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
            <li><a href="#B" data-toggle="tab">Successful Logins</a></li>
            <li><a href="#C" data-toggle="tab">Password Changes</a></li>
            <li><a href="#D" data-toggle="tab">Reset Passwords</a></li>
        </ul>

        <div class="tabbable">
            <div class="tab-content">
                <div class="tab-pane active" id="A">

                    {{ form.render("id") }}
                    {{ form.render("player") }}
                    <div class="clearfix">
                        <label for="player">Player: {{ userDetails.player }}</label>
                    </div>

                    <div class="span3">

                        <div class="clearfix">
                            <label for="name">Name</label>
                            {{ form.render("name") }}
                        </div>

                        <div class="clearfix">
                            <label for="email">E-Mail</label>
                            {{ form.render("email") }}
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
                            <label for="groupsId">Group</label>
                            {{ form.render("groupsId") }}
                        </div>

                        <div class="clearfix">
                            <label for="title">Title</label>
                            {{ form.render("title") }}
                        </div>
                    </div>
                    <div class="span3">
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

                        <div class="clearfix">
                            <label for="suspended">Suspended?</label>
                            {{ form.render("suspended") }}
                        </div>

                        <div class="clearfix">
                            <label for="banned">Banned?</label>
                            {{ form.render("banned") }}
                        </div>

                        <div class="clearfix">
                            <label for="active">Confirmed?</label>
                            {{ form.render("active") }}
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="B">
                    <p>
                    <table class="table table-bordered table-striped" align="center">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>IP Address</th>
                            <th>Date</th>
                            <th>User Agent</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for login in userDetails.successLogins %}
                        <tr>
                            <td>{{ login.id }}</td>
                            <td>{{ login.ipAddress }}</td>
                            <td>{{ date("Y-m-d H:i:s", login.createdAt) }}</td>
                            <td>{{ login.userAgent }}</td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan="3" align="center">User does not have successfull logins</td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

                <div class="tab-pane" id="C">
                    <p>
                    <table class="table table-bordered table-striped" align="center">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for change in userDetails.passwordChanges %}
                        <tr>
                            <td>{{ change.id }}</td>
                            <td>{{ change.ipAddress }}</td>
                            <td>{{ change.userAgent }}</td>
                            <td>{{ date("Y-m-d H:i:s", change.createdAt) }}</td>
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan="3" align="center">User has not changed his/her password</td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

                <div class="tab-pane" id="D">
                    <p>
                    <table class="table table-bordered table-striped" align="center">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Date</th>
                            <th>Reset?</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for reset in userDetails.resetPasswords %}
                        <tr>
                            <th>{{ reset.id }}</th>
                            <th>{{ date("Y-m-d H:i:s", reset.createdAt) }}
                            <th>{{ reset.reset == 'Y' ? 'Yes' : 'No' }}
                        </tr>
                        {% else %}
                        <tr>
                            <td colspan="3" align="center">User has not requested reset his/her password</td>
                        </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                    </p>
                </div>

            </div>
        </div>

</form>
</div>