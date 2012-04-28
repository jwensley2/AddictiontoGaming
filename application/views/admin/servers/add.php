<section id="content" class="content">
	<header>
		<h1>Administration - Servers - Add Server</h1>
	</header>

	<article>
		<?php echo validation_errors('<p class="error">', '</p>'); ?>

		<?php echo form_open('/admin/servers/edit_process/'.$server->id, array('id' => 'server_edit_form')) ?>
			<div class="row">
				<label for="f-name">Name</label>
				<input type="text" id="f-name" value="<?php echo set_value('name') ?>" name="name">
			</div>
			<div class="row">
				<label for="f-ip">IP</label>
				<input type="text" id="f-ip" value="<?php echo set_value('ip') ?>" name="ip">
			</div>
			<div class="row">
				<label for="f-port">Port</label>
				<input type="text" id="f-port" value="<?php echo set_value('port') ?>" name="port">
			</div>
			<div class="row">
				<label for="f-game">Game</label>
				<?php echo form_dropdown('game', $gametypes, $server->game, array('id' => 'f-game')) ?>
			</div>
			<input type="submit" value="Finish Editing" name="submit">
		</form>
	</article>
</section>