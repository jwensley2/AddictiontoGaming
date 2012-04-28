<!-- Content -->

<script type="text/javascript">
	$(function()
	{
		var config = {
			toolbar:
			[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Image', 'Link', 'Unlink'],
			],
			width: "100%",
			resize_maxWidth: 458,
			resize_minWidth: 458,
			resize: false,
			emailProtection: 'encode',
		};

		// Initialize the editor.
		// Callback function can be passed and executed after full instance creation.
		$(".custom-ckeditor").ckeditor(config);
	});
</script>

<section id="content" class="content">
	<header>
		<h1>Administration - News - Submit News</h1>
	</header>

	<article>
		<?php echo validation_errors('<p class="error">', '</p>'); ?>

		<?php echo form_open('/admin/news/submit_process/', array('id' => 'news-form')) ?>
			<div class="row">
				<label for="f-title">Title</label>
				<input type="text" value="<?php echo set_value('title', $news->title) ?>" id="f-title" name="title">
			</div>

			<div class="row">
				<label for="f-content">Content</label>
				<textarea class="custom-ckeditor" id="f-content" name="content"><?php echo set_value('content', $news->content) ?></textarea>
			</div>

			<input type="submit" value="Finish Editing">
		</form>
	</article>
</section>