<script type="text/javascript" charset="utf-8">
	$(function()
	{
		var config = {
			toolbar:
			[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Image', 'Link', 'Unlink'],
			],
			uiColor : "#737280",
			width: 470,
			resize_maxWidth: 458,
			resize_minWidth: 458,
			resize: false,
			emailProtection: 'encode',
		};

		// Initialize the editor.
		// Callback function can be passed and executed after full instance creation.
		$('.custom_ckeditor').ckeditor(config);
	});
	
</script>

<div id="content">
	<?php $this->load->view('/admin/templates/sidebar') ?>


	<div id="content_right">
		<div id="page_title" class="block cufon">News Administration</div>
		
		<?php echo validation_errors('<div class="block validation_error">', '</div>'); ?>
		
		<div class="block">
			<?php echo form_open('/admin/news/submit_process/', array('id' => 'news_form')) ?>
				<div class="row">
					<div class="heading">Title</div>
					<div class="element"><input type="text" value="<?php echo set_value('title', $news->title) ?>" name="title" /></div>
				</div>
				<div class="row">
					<div class="heading">Content</div>
					<div class="element"><textarea class="custom_ckeditor" id="content" name="content"><?php echo set_value('content', $news->content) ?></textarea></div>
				</div>
				<div class="row">
					<input type="submit" value="Finish Editing" />
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>