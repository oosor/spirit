<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Духовное Духовным, подстрочный перевод Библии, Симфонии ">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- stylesheets -->
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/font-awesome.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/ionicons.min.css') }}" />

        <link rel="stylesheet" type="text/css" href="{{ asset('dist/app.css') }}" />
    @show
</head>
<body>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lt IE 8]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
    <div class="box">
        @yield('content')
    </div>
<!-- javascript -->
@section('scripts')
    <script src="{{ asset('assets/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lib/axios.min.js') }}"></script>

    <script src="{{ asset('dist/app.js') }}"></script>
@show
</body>
</html>