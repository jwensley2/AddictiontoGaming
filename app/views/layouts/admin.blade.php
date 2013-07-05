<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>@yield('title') - [ATG] Addiction to Gaming</title>

	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="/assets/admin/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/admin/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/admin/css/master.css">

	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- TypeKit Fonts -->
	<script type="text/javascript" src="http://use.typekit.com/ove5wkp.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	@if(App::environment() === 'production')
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
	@endif
</head>
<body data-csrf-token="{{ csrf_token() }}">
	<div style="display: none">
		<!-- Delete Alert Template -->
		<div id="delete-alert-template" class="alert alert-block alert-error fade in">
			<button data-dismiss="alert" class="close" type="button">×</button>

			<h4 class="alert-heading">Are you sure you want to delete that?</h4>
			<p>You are about to delete "<strong class="title"></strong>", are you absolutely sure you want to delete it?</p>
			<p>
				<button class="btn btn-danger" data-action="delete">Delete It</button> <button class="btn" data-action="keep">Keep It</button>
			</p>
		</div>

		<!-- Error Alert Template -->
		<div id="error-alert-template" class="alert alert-block alert-error fade in">
			<button data-dismiss="alert" class="close" type="button">×</button>
		</div>

		<!-- Success Alert Template -->
		<div id="error-alert-template" class="alert alert-block alert-success fade in">
			<button data-dismiss="alert" class="close" type="button">×</button>
		</div>
	</div>

	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="{{ action('AdminController@index') }}">ATG Admin Panel</a>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<li><a href="{{ route('home') }}">Home</a></li>
						<li class="dropdown @if(Request::is('admin/news/*'))active@endif">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								News<b class="caret"></b>
							</a>

							<ul class="dropdown-menu">
								<li><a href="{{ action('NewsController@getIndex') }}">List News</a></li>
								<li><a href="{{ action('NewsController@getCreate') }}">Post News</a></li>
							</ul>
						</li>
						<li class="@if(Request::is('admin/donations/*'))active@endif">
							<a href="{{ action('AdminDonationsController@getIndex') }}">Donations</a>
						</li>
						<li class="@if(Request::is('admin/donors/*'))active@endif">
							<a href="{{ action('DonorsController@getIndex') }}">Donors</a>
						</li>
						<li class="@if(Request::is('admin/settings/*'))active@endif">
							<a href="#">Settings</a>
						</li>
					</ul>

					<ul class="nav pull-right">
						<li><a href="#">Account</a></li>
						<li><a href="{{ route('logout') }}">Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1 class="page-header">
					@yield('title')
				</h1>

				@yield('content')
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/admin/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/assets/admin/js/main.js"></script>

	<!-- Load and setup CKEditor -->
	<script type="text/javascript" src="/assets/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".editor").each(function() {
				CKEDITOR.replace($(this)[0], {
					customConfig: '/assets/ckeditor/config-admin.js'
				});
			});
		});
	</script>
</body>
</html>