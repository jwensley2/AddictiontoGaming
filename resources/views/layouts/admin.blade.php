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
	<link rel="stylesheet" type="text/css" href="/assets/admin/css/theme.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/assets/admin/css/master.css">

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
	<div style="display: none">
		<!-- Delete Alert Template -->
		<div id="delete-alert-template" class="alert alert-block alert-danger alert-dismissable fade in">
			<button data-dismiss="alert" class="close" type="button">&times;</button>

			<h4 class="alert-heading">Are you sure you want to delete that?</h4>
			<p>You are about to delete "<strong class="title"></strong>", are you absolutely sure you want to delete it?</p>
			<p>
				<button class="btn btn-danger" data-action="delete">Delete It</button>
				<button class="btn" data-action="keep">Keep It</button>
			</p>
		</div>

		<!-- Error Alert Template -->
		<div id="error-alert-template" class="alert alert-block alert-danger alert-dismissable fade in">
			<button data-dismiss="alert" class="close" type="button">×</button>
		</div>

		<!-- Success Alert Template -->
		<div id="success-alert-template" class="alert alert-block alert-success alert-dismissable fade in">
			<button data-dismiss="alert" class="close" type="button">×</button>
		</div>
	</div>

	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ action('Admin\AdminController@index') }}">ATG Admin</a>
			</div>

			<div id="navbar-collapse" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ route('home') }}">Home</a></li>

					@if (Auth::check())
						@if(Auth::user()->hasPermission('news_view'))
							<li class="dropdown {{Request::is('admin/news', 'admin/news/*') ? 'active' : ''}}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">News <b class="caret"></b></a>

								<ul class="dropdown-menu">
									<li class="{{Request::is('admin/news') ? 'active' : ''}}">
                                        <a href="{{ action('Admin\NewsController@getIndex') }}">List News</a>
                                    </li>
									@if(Auth::user()->hasPermission('news_post'))
                                        <li class="{{Request::is('admin/news/create') ? 'active' : ''}}">
                                            <a href="{{ action('Admin\NewsController@getCreate') }}">Post News</a>
                                        </li>
									@endif
								</ul>
							</li>
						@endif

						@if(Auth::user()->hasPermission('donations_view') OR Auth::user()->hasPermission('donors_view'))
							<li class="dropdown {{Request::is('admin/donations*', 'admin/donors*') ? 'active' : ''}}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Donations <b class="caret"></b></a>

								<ul class="dropdown-menu">
									@if(Auth::user()->hasPermission('donations_view'))
										<li class="{{Request::is('admin/donations') ? 'active' : ''}}">
											<a href="{{ action('Admin\DonationsController@getIndex') }}">List Donations</a>
										</li>
									@endif

									@if(Auth::user()->hasPermission('donors_view'))
										<li class="{{Request::is('admin/donors', 'admin/donors/*') ? 'active' : ''}}">
											<a href="{{ action('Admin\DonorsController@getIndex') }}">List Donors</a>
										</li>
									@endif
								</ul>
							</li>
						@endif

						@if(Auth::user()->hasPermission('settings'))
							<li class="{{Request::is('admin/settings') ? 'active' : ''}}">
								<a href="{{ action('Admin\SettingsController@getIndex') }}">Settings</a>
							</li>
						@endif

						@if(Auth::user()->hasPermission('users_view') OR Auth::user()->hasPermission('groups_view'))
                                <li class="dropdown {{Request::is('admin/users', 'admin/users/*', 'admin/groups/*') ? 'active' : ''}}">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Users <b class="caret"></b></a>

								<ul class="dropdown-menu">
									@if(Auth::user()->hasPermission('users_view'))
										<li class="{{Request::is('admin/users/*') ? 'active' : ''}}">
											<a href="{{ action('Admin\UserController@getList') }}">List Users</a>
										</li>
									@endif

									@if(Auth::user()->hasPermission('groups_view'))
										<li class="{{Request::is('admin/groups/*') ? 'active' : ''}}">
											<a href="{{ action('Admin\GroupController@getList') }}">List Groups</a>
										</li>
									@endif
								</ul>
							</li>
						@endif
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::check())
						<li><a href="{{ route('profile') }}">Account</a></li>
						<li><a href="{{ url('/logout') }}">Logout</a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12" id="alert-container"></div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">
					@yield('title')
				</h1>

				@yield('content')
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

	@if (App::environment('production'))
		<script type="text/javascript" src="/assets/admin/js/scripts.min.js"></script>
	@else
		<script type="text/javascript" src="/assets/admin/js/bootstrap/alert.js"></script>
		<script type="text/javascript" src="/assets/admin/js/bootstrap/transition.js"></script>
		<script type="text/javascript" src="/assets/admin/js/bootstrap/dropdown.js"></script>
		<script type="text/javascript" src="/assets/admin/js/bootstrap/collapse.js"></script>
		<script type="text/javascript" src="/assets/admin/js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="/assets/admin/js/jquery.tablesorter.widgets.js"></script>
		<script type="text/javascript" src="/assets/admin/js/main.js"></script>
	@endif

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