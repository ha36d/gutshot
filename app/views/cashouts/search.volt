{{ content() }}
<ul class="pager">
    <li class="pull-left">
        {{ link_to("cashouts/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
</ul>

<div class="center scaffold">
    <h2>Search Cashouts</h2>

    <form method="post" action="{{ url("cashouts/list") }}" autocomplete="off">

    <div class="clearfix">
        <label for="amount">Amount</label>
        {{ form.render("amount") }}
    </div>

    <div class="clearfix">
        <label for="usersId">User</label>
        {{ form.render("usersId") }}
    </div>

    <div class="clearfix">
        <label for="status">Status</label>
        {{ form.render("status") }}
    </div>

    <div class="clearfix">
        <div id="createdAtFromDiv" class="input-append date">
            <label for="createdAtFrom">Requested From</label>
            {{ form.render("createdAtFrom") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        <div id="createdAtToDiv" class="input-append date">
            <label for="createdAtTo">Requested To</label>
            {{ form.render("createdAtTo") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        <div id="paidAtFromDiv" class="input-append date">
            <label for="paidAtFrom">Paid From</label>
            {{ form.render("paidAtFrom") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        <div id="paidAtToDiv" class="input-append date">
            <label for="paidAtTo">Paid To</label>
            {{ form.render("paidAtTo") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        {{ submit_button("Search", "class": "btn btn-primary") }}
    </div>
    </form>

</div>

{{ stylesheet_link('css/bootstrap-datetimepicker.min.css') }}
{{ javascript_include('js/bootstrap-datetimepicker.min.js') }}
<script type="text/javascript">
    $(function () {
        $('#createdAtFromDiv,#createdAtToDiv,#paidAtFromDiv,#paidAtToDiv').datetimepicker({
            language: 'pt-BR'
        });
    });
</script>