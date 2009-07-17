{{ content() }}

<form method="post" autocomplete="off">

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("articles/list", "&larr; Go Back") }}
        </li>
        <li class="pull-right">
            {{ submit_button("Publish", "class": "btn btn-success") }}
        </li>
    </ul>

    <div class="center scaffold">
        <h2>Publish News</h2>

        <div class="clearfix">
            <label for="title">Title</label>
            {{ form.render("title") }}
        </div>

        <div class="clearfix">
            <label for="type">Type</label>
            {{ form.render("type") }}
        </div>

        <div class="clearfix">
            <label for="content">Content</label>
            {{ form.render("content") }}
        </div>

    </div>

</form>
{{ javascript_include('js/trumbowyg/trumbowyg.min.js') }}
{{ stylesheet_link('js/trumbowyg/ui/trumbowyg.min.css') }}

<script>
    $('#content').trumbowyg();
</script>