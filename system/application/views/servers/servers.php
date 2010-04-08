<div id="content">
	<?php $this->load->view('templates/sidebar') ?>


	<div id="content_right">
		<div id="page_title" class="block cufon">Server List</div>
		
		<div class="block">
			<?php foreach ($servers as $server): ?>
				<a class="banner" href="http://www.gametracker.com/server_info/<?php echo $server->ip ?>:<?php echo $server->port ?>/">
					<img width="466" src="http://cache.www.gametracker.com/server_info/<?php echo $server->ip ?>:<?php echo $server->port ?>/banner_560x95.png?random=547776" />
				</a>
			<?php endforeach ?>
		</div>
	</div>
	<div class="clear"></div>
</div>