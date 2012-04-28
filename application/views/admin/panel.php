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
		<h1>Administration Panel</h1>
	</header>

	<article>
		<h3>Available Options</h3>
		<ul>
			<?php if (permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'))): ?>
				<li><a href="/admin/news/submit">Submit News</a></li>
			<?php endif; ?>
			<?php if (permission($this->settingsmodel->get_setting_array('POTW_PERMISSIONS'))): ?>
				<li><a href="/admin/potw/submit">Add Player of the Month</a></li>
			<?php endif; ?>
			<?php if (permission($this->settingsmodel->get_setting_array('DONOR_LIST_PERMISSIONS'))): ?>
				<li><a href="/admin/donations/donors">List Donors</a></li>
			<?php endif; ?>
			<?php if (permission($this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS'))): ?>
				<li><a href="/admin/servers">List Servers</a></li>
			<?php endif; ?>
		</ul>
	</article>
</section>