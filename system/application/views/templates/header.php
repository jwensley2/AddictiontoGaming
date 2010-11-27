<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php if (isset($title)): ?>
			<title>[ATG] Addiction to Gaming <?php echo SEP ?> <?php echo $title ?></title>
		<?php else: ?>
			<title>[ATG] Addiction to Gaming</title>
		<?php endif ?>
		
		<!-- Stylesheets -->
		<?php
			//$this->asset_lib->deug == TRUE;
		
			$this->asset_lib->add_asset('reset', 'css');
			$this->asset_lib->add_asset('master', 'css');
			$this->asset_lib->add_asset('../colorbox/colorbox', 'css', 'base', FALSE);
			$this->asset_lib->add_asset('server_popups', 'css');
			$this->asset_lib->add_asset('custom-theme/jquery-ui', 'css');
			echo $this->asset_lib->output_tags('css', array('base', 'script'));
			
			$this->asset_lib->add_asset('jquery', 'js', 'header');
			$this->asset_lib->add_asset('jquery-ui-1.8.custom.min', 'js', 'header2', FALSE);
			$this->asset_lib->add_asset('../colorbox/jquery.colorbox-min', 'js', 'header');
			$this->asset_lib->add_asset('cufon', 'js', 'footer');
			$this->asset_lib->add_asset('MyriadPro.font', 'js', 'footer');
			$this->asset_lib->add_asset('server_popups', 'js', 'footer');
			$this->asset_lib->add_asset('main', 'js', 'footer');
			
			echo $this->asset_lib->output_tags('js', 'header');
			echo $this->asset_lib->output_tags('js', 'header2');
		?>

	</head>
	
	<body>
		<div id="server_popup_holder"></div>
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