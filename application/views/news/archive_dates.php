<!-- Content -->
<section id="content" class="content news-archive">
	<header>
		<h1>News Archive</h1>
	</header>

	<ul>
		<?php foreach ($dates as $date): ?>
			<li class="date">
				<a href="/news/archive/<?php echo date('m/Y', $date->date) ?>"><?php echo date('F Y', $date->date); ?></a>
			</li>
		<?php endforeach ?>
	</ul>
</section