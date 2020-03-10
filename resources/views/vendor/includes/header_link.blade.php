<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title')</title>
    <link rel="icon" type="image/jpg" href="{{ asset('assets/img/icon/nobin.png') }}"/>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/vendor/css/bootstrap.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css/zabuto_calendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/js/gritter/css/jquery.gritter.css') }}" /> {{--gritter--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/lineicons/style.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/vendor/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/css/style-responsive.css') }}" rel="stylesheet">


    <link href="{{ asset('assets/vendor/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />{{--date range picker--}}

    <script src="{{ asset('assets/vendor/js/chart-master/Chart.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>{{--ajax cdn--}}
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> <!--  jquery cdn-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="{{ asset('assets/vendor/js/tinymce/tinymce.min.js') }}"></script> {{--tinymce--}}
    <script src="https://cdn.tiny.cloud/1/jhv2goycu359q9scua0zdy5ec2pj3r2of9bxt2e09o198xnd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> {{--tinymce--}}
    <script src="{{ asset('assets/vendor/js/custom.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>{{--date rang epicker--}}









    <![endif]-->
</head>
