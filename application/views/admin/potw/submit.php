<!-- Content -->

<script type="text/javascript">
	$(document).ready(function (argument) {
		$('.date').datepicker();
	});

	$(function()
	{
		var config = {
			toolbar:
			[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Image', 'Link', 'Unlink'],
				['Source']
			],
			width: "100%",
			resize_maxWidth: 458,
			resize_minWidth: 458,
			resize: false,
			emailProtection: 'encode',
			extraPlugins: 'bbcode'
		};

		// Initialize the editor.
		// Callback function can be passed and executed after full instance creation.
		$(".custom-ckeditor").ckeditor(config);
	});
</script>

<section id="content" class="content">
	<header>
		<h1>Administration - PotM - Add Player</h1>
	</header>

	<article>
		<h2>Upcoming Players</h2>
		<?php if ($upcoming_players): ?>
			<ul>
				<?php foreach ($upcoming_players AS $player): ?>
					<li><?php echo date('M d, Y', $player->start_date) ?> - <?php echo $player->name ?></li>
				<?php endforeach ?>
			</ul>
		<?php else: ?>
			<p>There are no upcoming Players of the Month</p>
		<?php endif ?>

		<h2>Add a new Player</h2>

		<?php echo validation_errors('<p class="error">', '</p>'); ?>

		<?php echo form_open_multipart('/admin/potw/submit_process/', array('id' => 'motw_form')) ?>
			<div class="row">
				<label for="f-photo">Photo</label>
				<input type="file" id="f-photo" name="photo">
			</div>
			<div class="row">
				<label for="f-name">Name</label>
				<input type="text" id="f-name" value="<?php echo set_value('name') ?>" name="name">
			</div>
			<div class="row">
				<label for="f-real-name">Real Name</label>
				<input type="text" id="f-real-name" value="<?php echo set_value('real_name') ?>" name="real_name">
			</div>
			<div class="row">
				<label for="f-steam-id">Steam ID</label>
				<input type="text" id="f-steam-id" value="<?php echo set_value('steam_id') ?>" name="steam_id">
			</div>
			<div class="row">
				<label for="f-start-date">Start Date</label>
				<input type="text" id="f-start-date" value="<?php echo set_value('start_date') ?>" class="date" name="start_date">
			</div>
			<div class="row">
				<label for="f-forum-pst">Forum Post</label>
				<textarea id="f-forum-pst" class="custom-ckeditor" name="forum_post_text"><?php echo set_value('forum_post_text') ?></textarea>
			</div>

			<input type="submit" value="Add Player">
		</form>
	</article>
</section>