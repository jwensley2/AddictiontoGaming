<!-- Content -->
<section class="content servers">
	<header>
		<h1>Server List</h1>
	</header>

	<article>
		<?php foreach ($servers as $server): ?>
			<a href="http://www.gametracker.com/server_info/<?php echo $server->ip ?>:<?php echo $server->port ?>/">
				<img src="http://cache.www.gametracker.com/server_info/<?php echo $server->ip ?>:<?php echo $server->port ?>/b_560_95_1.png" alt=""/>
			</a>
		<?php endforeach ?>
	</article>
</section>