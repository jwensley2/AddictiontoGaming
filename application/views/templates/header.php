<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if (isset($title)): ?>
		<title>[ATG] Addiction to Gaming <?php echo SEP ?> <?php echo $title ?></title>
	<?php else: ?>
		<title>[ATG] Addiction to Gaming</title>
	<?php endif ?>

	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="/assets/css/master.css">
	<link rel="stylesheet" type="text/css" href="/assets/jquery-ui/css/smoothness/jquery-ui-1.8.19.custom.css">

	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- TypeKit Fonts -->
	<script type="text/javascript" src="http://use.typekit.com/ove5wkp.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<!-- Scripts -->
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.h5validate.js"></script>

	<script type="text/javascript">
		$(document).ready(function () {
			$("#donate-form").h5Validate({
				"errorAttribute" : "data-error",
				"errorClass"     : "error",
				"validClass"     : "valid"
			});
		});
	</script>

	<?php if (ENVIRONMENT === 'production'): ?>
		<!-- Google Analytics -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-9313553-1']);
			_gaq.push(['_setDomainName', 'addictiontogaming.com']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	<?php else: ?>
		<script type="text/javascript" src="/assets/js/cssrefresh.js"></script>
	<?php endif ?>

	<?php if ($this->uri->segment(1) == "admin"): ?>
		<script type="text/javascript" src="/assets/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/assets/ckeditor/adapters/jquery.js"></script>
	<?php endif ?>
</head>
<body>
	<div class="die-ie">
		Please upgrade your browser to view this site properly.<br>
		We recommend <a href="http://getfirefox.com">Mozilla Firefox</a> or <a href="http://www.google.com/chrome">Google Chrome</a>
	</div>

	<!-- Header -->
	<header class="page-header">
		<div class="o-wrap">
			<div class="i-wrap">
				<div class="tabs">
					<?php if (permission($this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS'))): ?>
						<a class="tab" href="<?php echo site_url('admin') ?>">Administration</a>
					<?php endif ?>
				</div>

				<h1>Addiction to Gaming</h1>
			</div>
		</div>
	</header>

	<div class="o-wrap main-wrapper">
		<!-- Navigation -->
		<nav class="navigation">
			<ul class="main-nav">
				<li><a href="<?php echo site_url('/') ?>">Home</a></li>
				<li><a href="http://forums.addictiontogaming.com">Forums</a></li>
				<li><a href="http://addictiontogaming.clanservers.com/">Bans</a></li>
				<li><a href="<?php echo site_url('servers') ?>">Servers</a></li>
				<li><a href="<?php echo site_url('donations') ?>">Donations</a></li>
			</ul>

			<ul class="sub-nav">
				<?php if ($this->uri->segment(1) == "admin"): ?>
					<?php if (permission($this->settingsmodel->get_setting_array('ADMIN_PANEL_PERMISSIONS'))): ?>
						<?php if (permission($this->settingsmodel->get_setting_array('NEWS_PERMISSIONS'))): ?>
							<li><a href="/admin/news/submit">Submit News</a></li>
						<?php endif; ?>
						<?php if (permission($this->settingsmodel->get_setting_array('POTW_PERMISSIONS'))): ?>
							<li><a href="/admin/potw/submit">Add Player of the Month</a></li>
						<?php endif; ?>
						<?php if (permission($this->settingsmodel->get_setting_array('DONOR_LIST_PERMISSIONS'))): ?>
							<li><a href="/admin/donations/donors">Donor List</a></li>
						<?php endif; ?>
						<?php if (permission($this->settingsmodel->get_setting_array('SERVER_LIST_PERMISSIONS'))): ?>
							<li><a href="/admin/servers">Server List</a></li>
						<?php endif; ?>
					<?php endif ?>
				<?php else: ?>
					<li><a href="<?php echo site_url('news/archive') ?>">News Archive</a></li>
				<?php endif ?>
			</ul>
		</nav>