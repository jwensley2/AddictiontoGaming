<script type="text/javascript" charset="utf-8">
	$(document).ready(function (argument) {
		$('.date').datepicker();
	});
</script>

<script type="text/javascript" charset="utf-8">
	$(function()
	{
		var config = {
			customConfig : '/assets/ckeditor/plugins/bbcode/atg/bbcode.config.js'
		};
		
		$('#forum_post').ckeditor(config);
	});
	
</script>

<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>


	<div id="content_right">
		<div id="page_title" class="block cufon">Admin - PotW - Add Player</div>
		
		<?php echo validation_errors('<div class="block validation_error">', '</div>'); ?>
		
		<div class="block">
			<div class="title">Upcoming Players</div>
			<?php if ($upcoming_players): ?>
				<?php foreach ($upcoming_players AS $player): ?>
					<?php echo date('M d, Y', $player->start_date) ?> - <?php echo $player->name ?>
				<?php endforeach ?>
			<?php else: ?>
				There are no upcoming Players of the Week
			<?php endif ?>
		</div>
		
		<div class="block">
			<div class="title">Add a new Player</div>
			<?php echo form_open_multipart('/admin/potw/submit_process/', array('id' => 'motw_form')) ?>
				<div class="row">
					<div class="heading">Photo</div>
					<div class="element"><input type="file" name="photo" /></div>
				</div>
				<div class="row">
					<div class="heading">Name</div>
					<div class="element"><input type="text" value="<?php echo set_value('name') ?>" name="name" /></div>
				</div>
				<div class="row">
					<div class="heading">Real Name</div>
					<div class="element"><input type="text" value="<?php echo set_value('real_name') ?>" name="real_name" /></div>
				</div>
				<div class="row">
					<div class="heading">Steam ID</div>
					<div class="element"><input type="text" value="<?php echo set_value('steam_id') ?>" name="steam_id" /></div>
				</div>
				<div class="row">
					<div class="heading">Start Date</div>
					<div class="element"><input type="text" value="<?php echo set_value('start_date') ?>" class="date" name="start_date" /></div>
				</div>
				<div class="row">
					<div class="heading">Forum Post</div>
					<div class="element"><textarea id="forum_post" name="forum_post_text" /><?php echo set_value('forum_post_text') ?></textarea></div>
				</div>
				<div class="row">
					<input type="submit" value="Submit" />
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>