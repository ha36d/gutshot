{{ content() }}
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("deposits/index", "&larr; Go Back") }}
    </li>
</ul>
<div class="center scaffold">
    {{ content() }}
    <h2>Deposit Result</h2>

    <div class="well" align="center">
        <p>
        {{ notice }}
        </p>
    </div>
</div>