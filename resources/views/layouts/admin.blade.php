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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">
        <div class="container">
            <a class="navbar-brand" href="{{ action('Admin\AdminController@index') }}">ATG Admin</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    @if (Auth::check())
                        @if(Auth::user()->hasPermission('news_view'))
                            <li class="nav-item dropdown {{Request::is('admin/articles', 'admin/articles/*') ? 'active' : ''}}">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">News</a>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item {{Request::is('articles') ? 'active' : ''}}"
                                       href="{{ route('admin.articles.index') }}">List News</a>
                                    @if(Auth::user()->hasPermission('news_post'))
                                        <a class="dropdown-item {{Request::is('admin/articles/create') ? 'active' : ''}}"
                                           href="{{ route('admin.articles.create') }}">Post News</a>
                                    @endif
                                </div>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('donations_view') OR Auth::user()->hasPermission('donors_view'))
                            <li class="nav-item dropdown {{Request::is('admin/donations*', 'admin/donors*') ? 'active' : ''}}">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Donations</a>

                                <div class="dropdown-menu">
                                    @if(Auth::user()->hasPermission('donations_view'))
                                        <a class="dropdown-item {{Request::is('admin/donations') ? 'active' : ''}}"
                                           href="{{ route('admin.donations.index') }}">List Donations</a>
                                    @endif

                                    @if(Auth::user()->hasPermission('donors_view'))
                                        <a class="dropdown-item {{Request::is('admin/donors', 'admin/donors/*') ? 'active' : ''}}"
                                           href="{{ route('admin.donors.index') }}">List Donors</a>
                                    @endif
                                </div>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('settings'))
                            <li class="nav-item {{Request::is('admin/settings') ? 'active' : ''}}">
                                <a class="nav-link" href="{{ route('admin.settings.index') }}">Settings</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('users_view') OR Auth::user()->hasPermission('groups_view'))
                            <li class="nav-item dropdown {{Request::is('admin/users', 'admin/users/*', 'admin/groups/*') ? 'active' : ''}}">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Users</a>

                                <div class="dropdown-menu">
                                    @if(Auth::user()->hasPermission('users_view'))
                                        <a class="dropdown-item {{Request::is('admin/users/*') ? 'active' : ''}}"
                                           href="{{ route('admin.users.index') }}">List Users</a>
                                    @endif

                                    @if(Auth::user()->hasPermission('groups_view'))
                                        <a class="dropdown-item {{Request::is('admin/groups/*') ? 'active' : ''}}"
                                           href="{{ route('admin.groups.index') }}">List Groups</a>
                                    @endif
                                </div>
                            </li>
                        @endif
                    @endif
                </ul>

                <ul class="navbar-nav">
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.account.edit') }}">Account</a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="{{ route('logout') }}">
                                {{ csrf_field() }}
                                <button class="btn btn-link nav-link">Logout</button>
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
                <h1 class="mt-5 mb-3">
                    @yield('title')
                </h1>

                <hr>

                <div v-for="alert in alerts">
                    <alert
                            :key="alert.key"
                            :alert-data="alert"
                            @close="closeAlert(alert)"
                    ></alert>
                </div>

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