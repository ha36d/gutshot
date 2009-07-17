{{ content() }}
<div class="center scaffold">
    <h2>Invitations</h2>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#A" data-toggle="tab">Invite</a></li>
        <li><a href="#B" data-toggle="tab">History</a></li>
    </ul>
    <div class="tabbable">
        <div class="tab-content">
            <div class="tab-pane active" id="A">
                <form method="post" autocomplete="off">

                    <div class="clearfix">
                        <label for="email">E-mail</label>
                        {{ form.render("email") }}
                    </div>
                    {{ submit_button("Send", "class": "btn btn-primary") }}

                </form>
            </div>

            <div class="tab-pane" id="B">
                {% for invitation in page %}
                {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Confirmed</th>
                    </tr>
                    </thead>
                    {% endif %}
                    <tbody>
                    <tr>
                        <td>{{ invitation.email }}</td>
                        <td>{{ invitation.confirmed }}</td>
                    </tr>
                    </tbody>
                    {% if loop.last %}
                    <tbody>
                    <tbody>
                </table>
                {% endif %}
                {% else %}
                No invitations are recorded
                {% endfor %}
            </div>

        </div>
    </div>
</div>