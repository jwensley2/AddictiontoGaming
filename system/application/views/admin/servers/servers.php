<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>


	<div id="content_right">
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$('.delete_server').click(function(){
					title = $(this).parents('.server1').children('.name').text();
					return confirm('Are you sure you want to delete "'+title+'"');
				})
			})
		</script>
		
		<div id="page_title" class="block cufon">Admin - Servers - Server List</div>
		
		<a class="block link cufon" href="/admin/servers/add">
			&raquo; Add a Server
		</a>
		
		<div class="block">
			<table id="server_list" border="0" cellspacing="0" cellpadding="0">
				<tr class="headings1">
					<th>Name</th>
					<th>Game</th>
					<th>RCON Password</th>
					<th>Actions</th>
				</tr>
				<tr class="headings2">
					<th>IP</th>
					<th>Port</th>
				</tr>
				<?php foreach ($servers as $server): ?>
					<tr class="server1">
						<td class="name"><?php echo $server->name ?></td>
						<td><?php echo strtoupper($server->game) ?></td>
						<td><?php echo $server->rcon_password ?></td>
						<td><a href="/admin/servers/edit/<?php echo $server->id ?>">edit</a> | <a class="delete_server" href="/admin/servers/delete/<?php echo $server->id ?>">delete</a></td>
					</tr>
					<tr class="server2">
						<td><?php echo $server->ip ?></td>
						<td><?php echo $server->port ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
	<div class="clear"></div>
</div>