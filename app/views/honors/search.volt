{{ content() }}
<ul class="pager">
    <li class="pull-left">
        {{ link_to("honors/list", "<i class='icon-list'></i> List", "class": "btn btn-primary") }}
    </li>
    <li class="pull-right">
        {{ link_to("honors/give", "<i class='icon-plus-sign'></i> Give Honor", "class": "btn btn-primary") }}
    </li>
</ul>

<div class="center scaffold">
    <h2>Search Honors</h2>

    <form method="post" action="{{ url("honors/list") }}" autocomplete="off">

    <div class="clearfix">
        <label for="usersId">User</label>
        {{ form.render("usersId") }}
    </div>

    <div class="clearfix">
        <div id="createdAtFromDiv" class="input-append date">
            <label for="createdAtFrom">Given From</label>
            {{ form.render("createdAtFrom") }}
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
        </div>
    </div>

    <div class="clearfix">
        <div id="createdAtToDiv" class="input-append date">
            <label for="createdAtTo">Given To</label>
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