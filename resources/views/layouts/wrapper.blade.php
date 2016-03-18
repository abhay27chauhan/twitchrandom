<!DOCTYPE html>
{{-- <html lang="en"> --}}
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield("meta")
    <meta name="robots" content="index,follow,noarchive" />
    <meta name="author" content="SpoonCo">

    @yield("title")

    @if(env('OFFLINE',true))
    <link rel="stylesheet" href="/css/offline/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="/css/offline/bootstrap-theme.min.css"> --}}
    @else
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"> --}}
    @endif
    {{--no internet --}}

    <link rel="stylesheet" href="/css/main.css">
    @yield("css")

    @if(!env('OFFLINE',true))
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @endif
</head>
<body>
    @yield("content")
    @if(env('OFFLINE', true))
    <script src="/js/offline/jquery.js"></script>
    <script src="/js/offline/bootstrap.min.js"></script>
    @else
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    @endif
    {{--<script src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>--}}
    <script src="/js/nicescroll.min.js"></script>
    <script src="/js/jquery.history.js"></script>
    <script src="//twemoji.maxcdn.com/2/twemoji.min.js"></script>
    @yield("js")
    @if(App::environment('production')) {{-- Don't use analytics for dev pages --}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-61997617-1', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');

    </script>
    @endif
    <script>
        twemoji.parse(document.body, {
            folder: 'svg',
            ext: '.svg',
            callback: function(icon, options, variant) {
                switch ( icon ) {
                    case 'a9':      // © copyright
                    case 'ae':      // ® registered trademark
                    case '2122':    // ™ trademark
                        return false;
                }
                return ''.concat(options.base, options.size, '/', icon, options.ext);
            }
        });
    </script>
</body>
</html>