<!DOCTYPE html>
<html>
<head>

    {!! SEO::generate() !!}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel='stylesheet' type='text/css'>


    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/assets/images/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/assets/images/favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/assets/images/favicons/manifest.json')}}">
    <link rel="mask-icon" href="{{url('/assets/images/favicons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">


{{--
    <link rel="apple-touch-icon" sizes="57x57" href="{{url('/assets/images/icon.ico/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{url('/assets/images/icon.ico/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('/assets/images/icon.ico/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('/assets/images/icon.ico/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{url('/assets/images/icon.ico/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('/assets/images/icon.ico/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('/assets/images/icon.ico/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/assets/images/icon.ico/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/assets/images/icon.ico/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{url('/assets/images/icon.ico/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/assets/images/icon.ico/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('/assets/images/icon.ico/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/icon.ico/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/assets/images/icon.ico/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{url('/assets/images/icon.ico/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">--}}

    {!! Html::style(elixir('assets/gulp/dashboard-styles.css')) !!}


{{--    {!! Html::style('assets/css/bootstrap.css') !!}
    {!! Html::style('assets/css/metisMenu.css') !!}
    {!! Html::style('assets/css/font-awesome.css') !!}
    {!! Html::style('assets/css/elegant-icons.css') !!}
    {!! Html::style('assets/css/pe-7-icons.css') !!}
    {!! Html::style('assets/css/pe-7-icons-helper.css') !!}
    {!! Html::style('assets/css/jquery-data-tables.css') !!}
    {!! Html::style('assets/css/jquery-data-tables-bs3.css') !!}
    {!! Html::style('assets/css/bootstrap3-wysihtml5.css') !!}
    {!! Html::style('assets/css/icheck-minimal.css') !!}
    {!! Html::style('assets/css/tether-shepherd.css') !!}
    {!! Html::style('assets/css/styles.css') !!}--}}





    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="preload theme-1" >