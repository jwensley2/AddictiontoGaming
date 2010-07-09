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
		
		<div class="block">
			<?php echo form_open('/admin/servers/edit_process/', array('id' => 'server_edit_form')) ?>
				<div class="row">
					<div class="heading">Name</div>
					<div class="element"><input type="text" value="<?php echo set_value('name', $server->name) ?>" name="name" /></div>
				</div>
				<div class="row">
					<div class="heading">IP</div>
					<div class="element"><input type="text" value="<?php echo set_value('ip', $server->ip) ?>" name="ip" /></div>
				</div>
				<div class="row">
					<div class="heading">Port</div>
					<div class="element"><input type="text" value="<?php echo set_value('port',  $server->port) ?>" name="port" /></div>
				</div>
				<div class="row">
					<div class="heading">Game</div>
					<div class="element">
						<select style="border:1px solid black; padding:5px;">
							<option value="css">Counter-Strike: Source</option>
							<option value="l4d">Left4Dead</option>
							<option value="l4d2">Left4Dead2</option>
							<option value="tf2">Team Fortress 2</option>
							<option value="vent">Ventrilo</option>
						</select>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>