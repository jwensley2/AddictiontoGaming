<!-- Content -->

<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$("#content").on("click", ".delete-news", function(){
			title = $(this).parents('article').children('h2:first-child').text();
			return confirm('Are you sure you want to delete "'+title+'"');
		})
	})
</script>

<section id="content" class="content news-articles">
	<header>
		<h1>News and Announcements</h1>
	</header>

	<?php foreach ($news as $item): ?>
		<article>
			<h2><?php echo $item->title ?></h2>
			<?php echo $item->content ?>

			<footer class="post-info">
				<div class="left">
					<?php if ($permissions['news']): ?>
						<a href="/admin/news/edit/<?php echo $item->id ?>">Edit</a> | <a class="delete-news" href="/admin/news/delete/<?php echo $item->id ?>">Delete</a>
					<?php endif ?>
				</div>
				<div class="right">
					<?php if ($item->date !== $item->modified): ?>
						<?php $item->edit_user_info = $this->phpbb_lib->getUserById($item->edit_user_id); ?>
						<p class="edit-date">
							Updated by
							<a class="edit-user" style="color:#<?php echo $item->edit_user_info['user_colour'] ?>" href="<?php echo FORUM_ROOT_PATH.'memberlist.php?mode=viewprofile&amp;u='.$item->edit_user_info['user_id'] ?>"><?php echo $item->edit_user_info['username']?></a>
							on <?php echo date('Y-m-d', $item->modified) ?>
						</p>
					<?php endif ?>
					<?php $item->user_info = $this->phpbb_lib->getUserById($item->user_id); ?>
					<p>
						Posted by
						<a class="user" style="color:#<?php echo $item->user_info['user_colour'] ?>" href="<?php echo FORUM_ROOT_PATH.'memberlist.php?mode=viewprofile&amp;u='.$item->user_info['user_id'] ?>"><?php echo $item->user_info['username']?></a>
						on <?php echo date('Y-m-d', $item->date) ?>
					</p>
				</div>
			</footer>
		</article>
	<?php endforeach ?>
</section>