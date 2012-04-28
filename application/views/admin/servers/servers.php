<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('.delete-server').click(function(){
			title = $(this).parents('.server1').children('.name').text();
			return confirm('Are you sure you want to delete "'+title+'"');
		})
	})
</script>

<section id="content" class="content">
	<header>
		<h1>Administration - Servers - Server List</h1>
	</header>

	<article>
		<a href="/admin/servers/add">&raquo; Add a Server</a>

		<table class="server-list">
			<thead>
				<tr>
					<th>Name</th>
					<th>Game</th>
					<th>RCON Password</th>
					<th>Actions</th>
				</tr>
				<tr>
					<th>IP</th>
					<th>Port</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($servers as $server): ?>
					<tr class="server1">
						<td class="name"><?php echo $server->name ?></td>
						<td><?php echo strtoupper($server->game) ?></td>
						<td><?php echo $server->rcon_password ?></td>
						<td><a href="/admin/servers/edit/<?php echo $server->id ?>">edit</a> | <a class="delete-server" href="/admin/servers/delete/<?php echo $server->id ?>">delete</a></td>
					</tr>
					<tr class="server2">
						<td><?php echo $server->ip ?></td>
						<td colspan="3"><?php echo $server->port ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</article>
</section>