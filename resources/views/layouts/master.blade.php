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

	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- TypeKit Fonts -->
	<script type="text/javascript" src="//use.typekit.net/ove5wkp.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	@if(App::environment('production'))
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-9313553-1', 'addictiontogaming.com');
			ga('send', 'pageview');
		</script>
	@endif
</head>
<body data-csrf-token="{{ csrf_token() }}">
	<div class="die-ie">
		Please upgrade your browser to view this site properly.<br>
		We recommend <a href="http://getfirefox.com">Mozilla Firefox</a> or <a href="http://www.google.com/chrome">Google Chrome</a>
	</div>

	<!-- Header -->
	<header class="page-header">
		<div class="o-wrap">
			<div class="i-wrap">
				<div class="tabs">
					@if (Auth::check())
						<a class="tab" href="/admin">Administration</a>
					@endif
				</div>

				<h1>Addiction to Gaming</h1>
			</div>
		</div>
	</header>

	<div class="o-wrap main-wrapper">
		<!-- Navigation -->
		<nav class="navigation">
			<ul class="main-nav">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li><a href="http://forums.addictiontogaming.com">Forums</a></li>
				{{--<li><a href="http://stats.addictiontogaming.com">Stats</a></li>--}}
				{{--<li><a href="http://bans.addictiontogaming.com">Bans</a></li>--}}
				<li><a href="{{ route('donations') }}">Donations</a></li>
			</ul>

			<ul class="sub-nav">
				@if (Auth::check())
					@if (Auth::user()->hasPermission('news_post'))
						<li><a href="{{ action('Admin\NewsController@getCreate') }}">Submit News</a></li>
					@endif
					@if (Auth::user()->hasPermission('donors_view'))
						<li><a href="{{ action('Admin\DonorsController@getIndex') }}">Donor List</a></li>
					@endif
				@endif
				<li><a href="{{ action('NewsController@getArchive') }}">News Archive</a></li>
			</ul>
		</nav>

		@yield('content')

		<!-- Sidebar -->
		<aside class="sidebar">
			<div class="block">
				<h2>Donation Progress</h2>
				<div class="progress-bar">
					<p>${{ $donations['total'] }} / ${{ $donations['goal'] }} ({{ $donations['percent'] }}%)</p>
					<div class="fill" style="width: {{ $donations['percent'] }}%"></div>
				</div>
			</div>

			<div class="block">
				<h2>Make a Donation</h2>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" accept-charset="utf-8" id="donate-form">
					<div style="display:none">
						<input type="hidden" name="cmd" value=" _donations">
						<input type="hidden" name="business" value="addictiontogaming@gmail.com">
						<input type="hidden" name="item_name" value="Donation">
						<input type="hidden" name="on0" value="SteamID">
						<input type="hidden" name="on1" value="Ingame Name">
						<input type="hidden" name="return" value="http://addictiontogaming.com/">
					</div>

					<input type="number" name="amount" placeholder="Donation Amount ($)" min="5" step="5" required>
					<input type="text" name="os0" placeholder="Steam ID (eg. STEAM_0:0:1234567)" pattern="^STEAM_0:[01]:[0-9]{7,8}">
					<input type="text" name="os1" placeholder="In Game Name">
					<input type="submit" value="Donate Now">
				</form>
			</div>
		</aside>
	</div>

	<!-- Footer -->
	<footer class="page-footer">
		<div class="o-wrap">
			<div class="i-wrap">
				<div class="col">
					<h3>Navigate</h3>
					<ul class="links">
						<li><a href="/">Home</a></li>
						<li><a href="http://forums.addictiontogaming.com">Forums</a></li>
						{{--<li><a href="http://stats.addictiontogaming.com">Stats</a></li>--}}
						{{--<li><a href="http://bans.addictiontogaming.com">Bans</a></li>--}}
						<li><a href="{{ route('donations') }}">Donations</a></li>
					</ul>
				</div>
				<div class="col">
					<h3>Contact Us</h3>
					<ul class="links">
						<li><a href="mailto:addictiontogaming@gmail.com">By Email</a></li>
						<li><a href="https://twitter.com/#!/atg_tf2">On Twitter</a></li>
						<li><a href="https://www.facebook.com/AddictionToGaming">On Facebook</a></li>
					</ul>
				</div>
				<div class="cf"></div>
				<div class="copyright">
					Copyright Addiction to Gaming {{ date('Y') }}
				</div>
			</div>
		</div>
	</footer>

	<!-- Scripts -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	@if (App::environment('production'))
		<script type="text/javascript" src="/assets/js/scripts.min.js"></script>
	@else
		<script type="text/javascript" src="/assets/js/cssrefresh.js"></script>
		<script type="text/javascript" src="/assets/js/zebra_dialog.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.h5validate.js"></script>
		<script type="text/javascript" src="/assets/js/main.js"></script>
	@endif

	<script type="text/javascript">
		$(document).ready(function () {
			$("#donate-form").h5Validate({
				"errorAttribute" : "data-error",
				"errorClass"     : "error",
				"validClass"     : "valid"
			});
		});
	</script>
</body>
</html>