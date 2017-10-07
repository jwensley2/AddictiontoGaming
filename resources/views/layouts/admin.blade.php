<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - [ATG] Addiction to Gaming</title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/app.css">

    @if(App::environment('production'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9313553-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments)
            };
            gtag('js', new Date());

            gtag('config', 'UA-9313553-1');
        </script>
    @endif
</head>
<body>
<div id="app">
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
                            <li class="dropdown {{Request::is('admin/articles', 'admin/articles/*') ? 'active' : ''}}">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">News <b
                                            class="caret"></b></a>

                                <ul class="dropdown-menu">
                                    <li class="{{Request::is('articles') ? 'active' : ''}}">
                                        <a href="{{ route('admin.articles.index') }}">List News</a>
                                    </li>
                                    @if(Auth::user()->hasPermission('news_post'))
                                        <li class="{{Request::is('admin/articles/create') ? 'active' : ''}}">
                                            <a href="{{ route('admin.articles.create') }}">Post News</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('donations_view') OR Auth::user()->hasPermission('donors_view'))
                            <li class="dropdown {{Request::is('admin/donations*', 'admin/donors*') ? 'active' : ''}}">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Donations <b
                                            class="caret"></b></a>

                                <ul class="dropdown-menu">
                                    @if(Auth::user()->hasPermission('donations_view'))
                                        <li class="{{Request::is('admin/donations') ? 'active' : ''}}">
                                            <a href="{{ route('admin.donations.index') }}">List Donations</a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->hasPermission('donors_view'))
                                        <li class="{{Request::is('admin/donors', 'admin/donors/*') ? 'active' : ''}}">
                                            <a href="{{ route('admin.donors.index') }}">List Donors</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('settings'))
                            <li class="{{Request::is('admin/settings') ? 'active' : ''}}">
                                <a href="{{ route('admin.settings.index') }}">Settings</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('users_view') OR Auth::user()->hasPermission('groups_view'))
                            <li class="dropdown {{Request::is('admin/users', 'admin/users/*', 'admin/groups/*') ? 'active' : ''}}">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Users <b
                                            class="caret"></b></a>

                                <ul class="dropdown-menu">
                                    @if(Auth::user()->hasPermission('users_view'))
                                        <li class="{{Request::is('admin/users/*') ? 'active' : ''}}">
                                            <a href="{{ route('admin.users.index') }}">List Users</a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->hasPermission('groups_view'))
                                        <li class="{{Request::is('admin/groups/*') ? 'active' : ''}}">
                                            <a href="{{ route('admin.groups.index') }}">List Groups</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                        <li><a href="{{ route('admin.account.edit') }}">Account</a></li>
                        <li>
                            <form class="navbar-form" method="post" action="{{ route('logout') }}">
                                {{ csrf_field() }}
                                <button class="btn btn-link btn-block">Logout</button>
                            </form>
                        </li>
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

                <alert v-for="(alert, i) in alerts"
                       :key="i"
                       :title="alert.title"
                       :message="alert.message"
                       :type="alert.type"
                       :buttons="alert.buttons"
                       :timer="alert.timer"
                       @close="closeAlert(i)"
                ></alert>

                @yield('content')
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script type="text/javascript" src="/assets/admin/js/app.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.1/classic/ckeditor.js"></script>
<script type="text/javascript" src="/assets/admin/js/ckeditor.js"></script>
</body>
</html>