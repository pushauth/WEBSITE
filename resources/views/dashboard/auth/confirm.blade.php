<!DOCTYPE html>
<html>
<head>
    <title>PushAuth</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Push Authentication service">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('/assets/images/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('/assets/images/favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/assets/images/favicons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/assets/images/favicons/manifest.json')}}">
    <link rel="mask-icon" href="{{url('/assets/images/favicons/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel='stylesheet' type='text/css'>



{!! Html::style('assets/css/bootstrap.css') !!}
{!! Html::style('assets/css/metisMenu.css') !!}
{!! Html::style('assets/css/font-awesome.css') !!}
{!! Html::style('assets/css/elegant-icons.css') !!}
{!! Html::style('assets/css/pe-7-icons.css') !!}
{!! Html::style('assets/css/pe-7-icons-helper.css') !!}
{!! Html::style('assets/css/tether-shepherd.css') !!}
{!! Html::style('assets/css/jstree-default.css') !!}
{!! Html::style('assets/css/styles.css') !!}
{!! Html::style('assets/css/authentication.css') !!}

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>	<body class="layout-no-leftnav">
<section class="login-section auth-section">
    <div class="container">
        <div class="row">
            <div class="form-box col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-sm-offset-0 xs-offset-0">
                <h1 class="form-box-heading logo text-center">
                    <img src="{{url('/assets/images/logo_white_small.png')}}"><span class="highlight">Push</span>Auth
                </h1>

                <div class="form-box-inner">
                    <h2 class="title text-center" style="margin-bottom:0px;">Request email confirmation</h2>
                    <div class="row">
                        <div class="form-container col-md-8 col-md-offset-2">

<center class="text-success">
                            <h3>Please, check your email for activate account.</h3>
</center>
                        </div>

                        </div>



                    </div>

                </div>

            </div>

        </div>

        <div class="copyright text-center">
            &copy; 2017 - PushAuth

        </div>	</div>

</section>



{!! Html::script('assets/js/jquery.js') !!}
{!! Html::script('assets/js/bootstrap.js') !!}
{!! Html::script('assets/js/metisMenu.js') !!}
{!! Html::script('assets/js/imagesloaded.js') !!}
{!! Html::script('assets/js/masonry.js') !!}
{!! Html::script('assets/js/pace.js') !!}

{!! Html::script('assets/js/tether.js') !!}
{!! Html::script('assets/js/tether-shepherd.js') !!}
{!! Html::script('assets/js/main.js') !!}
{!! Html::script('assets/js/tour.js') !!}


</body>
</html>