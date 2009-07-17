{{ content() }}

<form method="post">

    <h2>User Activity</h2>

    <div class="well" align="center">

        <table class="perms">
            <tr>
                <td>{{ select('usersId', users, 'using': ['id', 'player'], 'useEmpty': true, 'emptyText': 'Select a
                    User',
                    'emptyValue': '') }}
                </td>
                <td>{{ select('date', ['-1 hour':'Last hour', '-3 hour':'Last 3 hours', '-12 hours':'Last 12 hours', '-1 day' : 'Last day', '-2 days' : 'Last 2 days'], 'useEmpty': true, 'emptyText': 'From
                    the beginning',
                    'emptyValue': '') }}
                </td>
                <td>{{ submit_button('Search', 'class': 'btn btn-primary') }}</td>
            </tr>
        </table>

    </div>
</form>
{% if request.isPost() and AccountsGet is defined %}
<div class="center scaffold">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Basic</a></li>
        <li><a href="#B" data-toggle="tab">Successful Logins</a></li>
        <li><a href="#C" data-toggle="tab">Password Changes</a></li>
        <li><a href="#D" data-toggle="tab">Reset Passwords</a></li>
        <li><a href="#E" data-toggle="tab">Deposits</a></li>
        <li><a href="#F" data-toggle="tab">Cashouts</a></li>
        <li><a href="#G" data-toggle="tab">Transfers</a></li>
        <li><a href="#H" data-toggle="tab">Honors</a></li>
        <li><a href="#I" data-toggle="tab">Hands</a></li>
        <li><a href="#J" data-toggle="tab">Support</a></li>
        <li><a href="#K" data-toggle="tab">Balances</a></li>
    </ul>

    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">

                <div class="span4">

                    <div class="clearfix">
                        Player: {{ userDetails.player }}
                    </div>

                    <div class="clearfix">
                        Name: {{ userDetails.name }}
                    </div>

                    <div class="clearfix">
                        Title: {{ userDetails.title }}
                    </div>

                    <div class="clearfix">
                        Level: {{ userDetails.level }}
                    </div>

                    <div class="clearfix">
                        Group: {{ userDetails.group.name }}
                    </div>


                </div>

                <div class="span4">

                    <div class="clearfix">
                        E-mail: {{ userDetails.email }}
                    </div>

                    <div class="clearfix">
                        Location: {{ userDetails.location }}
                    </div>

                    <div class="clearfix">
                        Gender: {{ userDetails.gender }}
                    </div>

                    <div class="clearfix">
                        Suspended: {{ userDetails.suspended == 'Y' ? 'Yes' : 'No' }}
                    </div>

                    <div class="clearfix">
                        Banned: {{ userDetails.banned == 'Y' ? 'Yes' : 'No' }}
                    </div>

                    <div class="clearfix">
                        Active: {{ userDetails.active == 'Y' ? 'Yes' : 'No' }}
                    </div>

                </div>
                <div class="span4">
                    <div class="clearfix">
                        Balance: {{ AccountsGet.Balance }}
                    </div>

                    <div class="clearfix">
                        Logins: {{ AccountsGet.Logins }}
                    </div>

                    <div class="clearfix">
                        First Login: {{ AccountsGet.FirstLogin }}
                    </div>

                    <div class="clearfix">
                        Last Login: {{ AccountsGet.LastLogin }}
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="B">
                <p>
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for login in successLogins %}
                    <tr>
                        <td>{{ login.ipAddress }}</td>
                        <td>{{ login.userAgent }}</td>
                        <td>{{ date("Y-m-d H:i:s", login.createdAt) }}</td>
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
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for change in passwordChanges %}
                    <tr>
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
                        <th>Date</th>
                        <th>Reset?</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for reset in resetPasswords %}
                    <tr>
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

            <div class="tab-pane" id="E">
                <p>
                    {% for deposit in deposits %}
                    {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Operator</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ deposit.user.player }} </td>
                        <td>{{ deposit.amount }}</td>
                        <td>{{ deposit.ref }}</td>
                        <td>{{ deposit.status == 'Yes' ? 'Success' : 'Failed' }}</td>
                        <td>{{ deposit.type }}</td>
                        <td>{{ deposit.operator }}</td>
                        <td>{{ deposit.comment }}</td>
                        <td>{{ date("Y-m-d H:i", deposit.createdAt) }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No deposits are recorded
                {% endfor %}
                </p>
            </div>

            <div class="tab-pane" id="F">
                <p>
                    {% for cashout in cashouts %}
                    {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Card</th>
                        <th>Account</th>
                        <th>Holder</th>
                        <th>Bank</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status?</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ cashout.card }}</td>
                        <td>{{ cashout.account }}</td>
                        <td>{{ cashout.holder }}</td>
                        <td>{{ cashout.bank }}</td>
                        <td>{{ cashout.amount }}</td>
                        <td>{{ date("d M Y H:i",cashout.createdAt) }}</td>
                        <td>{{ cashout.status == 'Yes' ? 'Paid at ' ~ date("d M Y H:i",cashout.paidAt) : 'Not Paid' }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No cashouts are recorded
                {% endfor %}
                </p>
            </div>

            <div class="tab-pane" id="G">
                <p>
                    {% for transfer in transfers %}
                    {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ transfer.userOut.player }}</td>
                        <td>{{ transfer.userIn.player }}</td>
                        <td>{{ transfer.comment }}</td>
                        <td>{{ transfer.amount }}</td>
                        <td>{{ date("Y-m-d H:i", transfer.createdAt) }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No transfers are recorded
                {% endfor %}
                </p>
            </div>
            <div class="tab-pane" id="H">
                <p>
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
                    {% for honor in honors %}
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
                </table>
                {% endif %}
                {% else %}
                No Honors are recorded
                {% endfor %}
                </p>
            </div>
            <div class="tab-pane" id="I">
                <p>
                    {% for handhistory in handhistories %}
                    {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Game</th>
                        <th>Hand Number</th>
                        <th>Hand</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ handhistory.player }}</td>
                        <td>{{ handhistory.type == 'Yes' ? 'Won' : 'Lost' }}</td>
                        <td>{{ handhistory.amount }}</td>
                        <td>{{ handhistory.name }}</td>
                        <td>{{ handhistory.hand_number }}</td>
                        <td>{{ handhistory.hand }}</td>
                        <td>{{ date("Y-m-d H:i:s", handhistory.createdAt) }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No HandHistories are recorded
                {% endfor %}
                </p>
            </div>

            <div class="tab-pane" id="J">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="icon-comment"></span>
                    </div>
                    <div class="panel-body">
                        <ul class="chat">
                            {% for support in supports %}
                            {% if support.type == 'respond' %}

                            <li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&amp;text=U" alt="User Avatar"
                                 class="img-circle">
                        </span>

                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <small class=" text-muted"><span class="icon-time"></span>{{ date(" d M H:i",
                                            support.createdAt) }}
                                        </small>
                                        <strong class="pull-right primary-font">Support</strong>
                                    </div>
                                    <p>
                                        {{ support.content }}
                                    </p>
                                </div>
                            </li>
                            {% else %}
                            <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&amp;text=ME" alt="User Avatar"
                                 class="img-circle">
                        </span>

                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">{{ support.users.player }}</strong>
                                        <small class="pull-right text-muted">
                                            <span class="icon-time"></span>{{ date(" d M H:i", support.createdAt) }}
                                        </small>
                                    </div>
                                    <p>
                                        {{ support.content }}
                                    </p>
                                </div>
                            </li>
                            {% endif %}

                            {% else %}
                            No support is recorded
                            {% endfor %}
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="K">
                <p>
                    {% for balancesDetail in balancesDetails %}
                    {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Player</th>
                        <th>Change</th>
                        <th>Balance</th>
                        <th>Source</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ balancesDetail.player }}</td>
                        <td>{{ balancesDetail.amountChange }}</td>
                        <td>{{ balancesDetail.amountBalance }}</td>
                        <td>{{ balancesDetail.src }}</td>
                        <td>{{ date("Y-m-d H:i:s", balancesDetail.createdAt) }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                </table>
                {% endif %}
                {% else %}
                No balance are recorded
                {% endfor %}
                </p>
            </div>

        </div>
    </div>
</div>
{% endif %}