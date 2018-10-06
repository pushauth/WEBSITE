<!DOCTYPE html>
<html>
<head>
    <title>PushAuth</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
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
                    <h2 class="title text-center">{{$title}}</h2>
                    <div class="row">
                        <div class="form-container col-md-6 col-md-offset-3">

                            <h4>{{$message}}</h4>
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