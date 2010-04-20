<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php if (isset($title)): ?>
			<title>[ATG] Addiction to Gaming - <?php echo $title ?></title>
		<?php else: ?>
			<title>[ATG] Addiction to Gaming</title>
		<?php endif ?>
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="/assets/css/reset.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="/assets/css/master.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="/assets/css/server_popups.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="/assets/css/custom-theme/jquery-ui.css" type="text/css" media="screen" charset="utf-8" />
		<?php if (isset($stylesheets)): ?>
			<?php foreach ($stylesheets as $stylesheet): ?>
				<link rel="stylesheet" href="/assets/css/<?php echo $stylesheet ?>" type="text/css" media="screen" charset="utf-8" />
			<?php endforeach ?>
		<?php endif ?>
		
		<!-- Scripts -->
		<script src="/assets/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/jquery-ui-1.8.custom.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/cufon.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/MyriadPro.font.js" type="text/javascript" charset="utf-8"></script>
		<script src="/assets/js/server_popups.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript" charset="utf-8">
			Cufon.replace('.cufon');
		</script>
		
		<?php if (isset($scripts)): ?>
			<?php foreach ($scripts as $script): ?>
				<script src="/assets/js/<?php echo $script ?>" type="text/javascript" charset="utf-8"></script>
			<?php endforeach ?>
		<?php endif ?>
	</head>
	
	<body>
		<div id="server_popup_holder">a</div>
		<div id="wrapper">
			<div id="header"></div>
			
			<div id="nav">
				<ul class="cufon">
					<li><a href="/">Home</a></li>
					<li><a href="http://forums.addictiontogaming.com">Forums</a></li>
					<li><a href="/stats">Stats</a></li>
					<li><a href="/sourcebans">Bans</a></li>
					<li><a href="/servers">Servers</a></li>
				</ul>
				<div class="clear"></div>
			</div>
			
			<div id="server_status">
				<div class="heading cufon">Server Status</div>
				<?php $servers = $this->serversmodel->list_servers($games) ?>
				<?php $i = 1; foreach ($servers as $server): ?>
					<?php if ($i % 4 == 1 && $i !== 1): ?><div class="clear"></div></div><?php endif; ?>
					<?php if ($i % 4 == 1): ?>
						<div class="row">
							<div class="server rowstart">
								<div class="status <?php echo status_to_class($server->status) ?>"></div>
								<div class="server_name"><?php echo $server->name ?></div>
								<?php if ($server->status == 1): ?>
									<div class="num_players"><?php echo $server->players ?>/<?php echo $server->max_players ?></div>
								<?php endif ?>
								<div class="server_id"><?php echo $server->id ?></div>
							</div>
					<?php else: ?>
						<div class="server">
							<div class="status <?php echo status_to_class($server->status) ?>"></div>
							<div class="server_name"><?php echo $server->name ?></div>
							<?php if ($server->status == 1): ?>
								<div class="num_players"><?php echo $server->players ?>/<?php echo $server->max_players ?></div>
							<?php endif ?>
							<div class="server_id"><?php echo $server->id ?></div>
						</div>
					<?php endif ?>
				<?php $i++; endforeach ?>
					<div class="clear"></div>
				</div>
			</div>