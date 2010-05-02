<div id="content">
	<?php $this->load->view('templates/sidebar') ?>


	<div id="content_right">
		
		<div id="page_title" class="block cufon">News and Announcements Archive</div>
		
		<div class="block">
			<ul id="archive_months">
				<?php foreach ($dates as $date): ?>
					<li class="date">
						<a href="/news/archive/<?php echo date('m/Y', $date->date) ?>">&raquo; <?php echo date('F Y', $date->date); ?></a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>