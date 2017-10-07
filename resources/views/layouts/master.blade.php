<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(!empty($title))
        <title>[ATG] Addiction to Gaming - {{ $title }}</title>
    @else
        <title>[ATG] Addiction to Gaming</title>
    @endif

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="/assets/css/app.css">

    <!-- TypeKit Fonts -->
    <script src="https://use.typekit.net/ove5wkp.js"></script>
    <script>try {Typekit.load({async: true});} catch (e) {}</script>

    @if(App::environment('production'))
        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-9313553-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments)};
            gtag('js', new Date());

            gtag('config', 'UA-9313553-1');
        </script>
    @endif
</head>
<body>
<div id="app">
    <confirmation></confirmation>

    <!-- Header -->
    <header class="page-header">
        <div class="o-wrap">
            <div class="i-wrap">
                <div class="tabs">
                    @if (auth()->check() && auth()->user()->active)
                        <a class="tab" href="{{ route('admin.home') }}">Administration</a>
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
                        <li><a href="{{ route('admin.articles.create') }}">Submit News</a></li>
                    @endif
                    @if (Auth::user()->hasPermission('donors_view'))
                        <li><a href="{{ route('admin.donors.index') }}">Donor List</a></li>
                    @endif
                @endif
                <li><a href="{{ route('news.archive') }}">News Archive</a></li>
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
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" accept-charset="utf-8"
                      id="donate-form">
                    <div style="display:none">
                        <input type="hidden" name="cmd" value=" _donations">
                        <input type="hidden" name="business" value="addictiontogaming@gmail.com">
                        <input type="hidden" name="item_name" value="Donation">
                        <input type="hidden" name="on0" value="SteamID">
                        <input type="hidden" name="on1" value="Ingame Name">
                        <input type="hidden" name="return" value="http://addictiontogaming.com/">
                    </div>

                    <input type="number" name="amount" placeholder="Donation Amount ($)" min="5" step="5" required>
                    <input type="text" name="os0" placeholder="Steam ID (eg. STEAM_0:0:1234567)"
                           pattern="^STEAM_0:[01]:[0-9]{7,8}">
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
</div>
<!-- Scripts -->
<script type="text/javascript" src="/assets/js/app.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#donate-form").h5Validate({
            "errorAttribute": "data-error",
            "errorClass": "error",
            "validClass": "valid"
        });
    });
</script>
</body>
</html>