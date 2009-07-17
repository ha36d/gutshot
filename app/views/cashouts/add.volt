<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("cashouts", "&larr; Go Back") }}
        </li>
    </ul>

    {{ content() }}

    <div class="center scaffold">
        <h2>Cash Out</h2>

        <div class="clearfix">
            <label for="amount">Amount</label>
            {{ form.render("amount") }}
        </div>
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
            {{ submit_button("Cash out", "class": "btn btn-primary") }}
        </div>

    </div>

</form>