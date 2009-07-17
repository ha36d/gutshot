{{ flashSession.output() }}
{{ content() }}

<form method="post">

<h2>Manage Permissions</h2>

<div class="well" align="center">

	<table class="perms">
		<tr>
			<td><label for="groupId">Group</label></td>
			<td>{{ select('groupsId', groups, 'using': ['id', 'name'], 'useEmpty': true, 'emptyText': '...', 'emptyValue': '') }}</td>
			<td>{{ submit_button('Search', 'class': 'btn btn-primary') }}</td>
		</tr>
	</table>

</div>

{% if request.isPost() and group %}
{{ hidden_field('groupId', 'value':groupId) }}
{% for resource, actions in acl.getResources() %}

	<h3>{{ resource }}</h3>

	<table class="table table-bordered table-striped" align="center">
		<thead>
			<tr>
				<th width="5%"></th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			{% for action in actions %}
			<tr>
				<td align="center"><input type="checkbox" name="permissions[]" value="{{ resource ~ '.' ~ action }}"  {% if permissions[resource ~ '.' ~ action] is defined %} checked="checked" {% endif %}></td>
				<td>{{ acl.getActionDescription(action) ~ ' ' ~ resource }}</td>
			</tr>
			{% endfor %}
		</tbody>
	</table>

{% endfor %}

{% endif %}

</form>