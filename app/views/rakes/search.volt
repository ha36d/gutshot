{{ content() }}

<ul class="pager">
    <li class="pull-left">
        {{ link_to("rakes/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
</ul>
<div class="center scaffold">
    <h2>Search Rakes</h2>

    <form method="post" action="{{ url("rakes/list") }}" autocomplete="off">

    <div class="clearfix">
        <label for="fromId">From User</label>
        {{ form.render("fromId") }}
    </div>

    <div class="clearfix">
        <label for="toId">To User</label>
        {{ form.render("toId") }}
    </div>

    <div class="clearfix">
        <div id="createdAtFromDiv" class="input-append date">
            <label for="createdAtFrom">Date From</label>
            {{ form.render("createdAtFrom") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        <div id="createdAtToDiv" class="input-append date">
            <label for="createdAtTo">Date To</label>
            {{ form.render("createdAtTo") }}
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
        $('#createdAtFromDiv,#createdAtToDiv').datetimepicker({
            language: 'pt-BR'
        });
    });
</script>