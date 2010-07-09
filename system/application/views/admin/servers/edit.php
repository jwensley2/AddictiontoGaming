<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>

	<div id="content_right">
		
		<div id="page_title" class="block cufon">Admin - Servers - Edit Server</div>
		
		<?php echo validation_errors('<div class="block validation_error">', '</div>'); ?>
		
		<div class="block">
			<?php echo form_open('/admin/servers/edit_process/'.$server->id, array('id' => 'server_edit_form')) ?>
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
						<?php echo form_dropdown('game', $gametypes, $server->game) ?>
					</div>
				</div>
				<div class="row">
					<div class="element"><input type="submit" value="Finish Editing" name="submit" /></div>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>