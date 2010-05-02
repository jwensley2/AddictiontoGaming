<div id="content">
	<?php $this->load->view('templates/sidebar') ?>


	<div id="content_right">
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$('.delete_news').click(function(){
					title = $(this).parents('.news_item').children('.title').text();
					return confirm('Are you sure you want to delete "'+title+'"');
				})
			})
		</script>
		
		<div id="page_title" class="block cufon">News and Announcements</div>
		
		<a class="block link cufon" href="/news/archive">
			&raquo; View News Archive
		</a>
		
		<?php foreach ($news as $item): ?>
			<div class="block news_item">
				<div class="title cufon"><?php echo $item->title ?></div>
				<div class="content">
					<?php echo $item->content ?>
					<?php if ($item->date !== $item->modified): ?>
						<?php $item->edit_user_info = $this->phpbb_lib->getUserById($item->edit_user_id); ?>
						<div class="edit_date">
							Last Edited <?php echo date('M j, Y \a\t g:i a', $item->modified) ?> by 
							<a class="edit_user" style="color:#<?php echo $item->edit_user_info['user_colour'] ?>" href="<?php echo FORUM_ROOT_PATH.'memberlist.php?mode=viewprofile&amp;u='.$item->edit_user_info['user_id'] ?>">
								<?php echo $item->edit_user_info['username']?>
							</a>
						</div>
					<?php endif ?>
				</div>
				<?php $item->user_info = $this->phpbb_lib->getUserById($item->user_id); ?>
				<div class="date">
					Posted <?php echo date('M j, Y \a\t g:i a', $item->date) ?> by 
					<a class="user" style="color:#<?php echo $item->user_info['user_colour'] ?>" href="<?php echo FORUM_ROOT_PATH.'memberlist.php?mode=viewprofile&amp;u='.$item->user_info['user_id'] ?>">
						<?php echo $item->user_info['username']?>
					</a>
					<?php if ($permissions['news']): ?>
						| <a href="/admin/news/edit/<?php echo $item->id ?>">Edit</a>
						- <a class="delete_news" href="/admin/news/delete/<?php echo $item->id ?>">Delete</a>
					<?php endif ?>
				</div>
			</div>
		<?php endforeach ?>
		
			<a class="block link cufon" href="/news/archive">
				&raquo; View News Archive
			</a>
	</div>
	<div class="clear"></div>
</div>