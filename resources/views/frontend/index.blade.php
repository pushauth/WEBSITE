@include('frontend.layout.head')
@include('frontend.layout.loaders')
@include('frontend.layout.nav')
{!!  Html::style('assets/js/highlight/styles/zenburn.css') !!}
<style>
    .btn-pink-alt:hover, .btn-pink-alt:focus, .btn-pink-alt.active, .btn-pink-alt.hover {
        border-color: #ffffff;
        background: #ffffff;
        color: rgb(113, 117, 236);
    }
    .tp--header-shrink.shrink .signbtn {
        background: none;
        border: 1px solid #f28bc7;
        color: #f28bc7;
    }
</style>
<!-- Hero Section
================================================== -->
<section id="intro" class="tp--intro tp--intro-dark tp--slider-single tp--owl-carousel-single owl-carousel owl-theme tp--intro-height-100" data-carousel-options='{ "items": "1", "mouseDrag": false, "touchDrag": false, "responsive": { "0": { "items":"1" } } }'>

    <div class="item tp--intro-content-left text-sm-center tp--gradient-3 tp--pattern-1 tp--intro-diagonal tp--intro-diagonal-1">

        <div class="container">

            <div class="row tp--col-sm-vertical-align tp--col-xs-vertical-align tp--vertical-align-intro">

                <div class="col-sm-12 col-md-5 col-md-offset-1">
                    <div>
                        <h1 style="font-size: 40px;">Push Authorization</h1>
                        <p>At one click, Fast and Easy Auth for your clients by<br>
                        security requests, codes and QR-codes.</p>
                        <a class="btn btn-lg btn-pink-alt" style="font-size: 20px;
    font-weight: 300;
    line-height: 2;" href="{{route('frontend.example')}}">Try example!</a>

                        <div class="text-left" style="padding-top: 40px;">
                            <a href="https://itunes.apple.com/vn/app/push-auth/id1242326600?mt=8">


                            <img style=" width: 150px; margin: 0;display: inline;" src="{{url('frontend/images/apple-store-badge.png')}}"></a>
                            <a href="https://play.google.com/store/apps/details?id=com.vladyslav.pushauth">
                            <img style=" width: 150px; margin: 0;display: inline;" src="{{url('frontend/images/google-play-badge.png')}}">
                            </a>

                        </div>

                        {{--<div class="text-left" style="padding-top: 30px;">
                           <img style="width: 100px; display: inline;" class="img-responsive" src="{{url('frontend/images/apple-store-badge.png')}}">
                            <img style="width: 100px; display: inline;"  class="img-responsive" src="{{url('frontend/images/google-play-badge.png')}}">
                        </div>--}}
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-md-offset-1 hidden-sm tp--margin-top-0">

                    <img src="{{url('frontend/images/devices/device-iphone-1.png')}}" class="visible-xl img-responsive img-65" alt="">
                    <img src="{{url('frontend/images/devices/device-iphone-1.png')}}" class="visible-lg hidden-xl img-responsive img-60" alt="">
                    <img src="{{url('frontend/images/devices/device-iphone-1.png')}}" class="visible-md img-responsive img-80" alt="">
                </div>
            </div>

        </div>

    </div>

</section>



<!-- About Section
================================================== -->
<section id="about" class="tp--section tp--features text-center">

    <div class="page-header text-center tp--title-overlay">
        <h2 data-title="VERY FAST"><span>How it works</span></h2>
    </div>

    <div class="container">

        <div class="row">

<div class="col-md-6">

    <div class="embed-responsive embed-responsive-4by3">
        <iframe src="https://player.vimeo.com/video/224736901" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>



    </div>

<br>
    <div>
        <a href="{{route('frontend.example')}}">
        <span type="button" class="btn btn-lg btn-pink"><i class="fa fa-play-circle"></i>  Try example now!</span>
        </a>


    </div>
</div>
            <div class="col-md-6 text-left">


                <h4 class="text-center">Push Request</h4>
                <pre><code class="php">&lt;?php

$authRequest = new PushAuth('Public-Key', 'Private-Key');

$authRequest->to('client@example.com')
            ->mode('push')
            ->response(false)
            ->send();

if (is_null($authRequest->isAccept())) {
             echo "Client answer timeout...";
             }

if ($authRequest->isAccept() == 'true') {
             echo "You are logged in...";
             }

if ($authRequest->isAccept() == 'true') {
             echo "Access denied!";
             }</code></pre>


            </div>



{{--            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-download icon-large"></i>
                </div>
                <h3>Client install App</h3>
                <p>And register in App without any password, only via email and confirmation.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient icon-layers icon-large"></i>
                </div>
                <h3>Client SingIn at service or web-site</h3>
                <p>PushAuth send Push request or code to client and response to service.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient icon-speech icon-large"></i>
                </div>
                <h3>Client answer to push or submit code.</h3>
                <p>And can singIn to service.</p>
            </div>--}}
        </div><!-- /.row -->
    </div>

</section>




<!-- Featured Sections
================================================== -->
<section id="featured11" class="tp--section tp--featured tp--diagonal tp--diagonal-1">

    <div class="container">
        <div class="row tp--col-sm-vertical-align">

            <div class="col-md-5 text-center text-md-left">
                <h2 class="title">Auth question & Security code</h2>
                <p>We provide for authorization several types. For access, clients can answer to question: 'yes' or 'no'.
                Or can input security code, that received to mobile application. All push messages and traffic are secure,
                using TLS and HMAC data signature. For access to mobile application, clients can use TouchID or PIN-code, that app doing more secure.</p>
               {{-- <a href="#">
                    <span class="btn btn-default btn-oval">More information</span>
                </a>--}}

            </div>

            <div class="col-md-6 col-md-offset-1">
                <img src="{{url('frontend/images/featured-img-2.png') }}" class="img-responsive" alt="">
            </div>

        </div>
    </div>

</section>



<!-- Featured Sections
================================================== -->
<section id="featured2" class="tp--section tp--featured tp--section-with-bg tp--section-with-bg p-top-md-200 p-bottom-md-200 tp--no-background-sm tp--no-background-xs" style="background-image: url('frontend/images/devices/device-macbook-2.png'); background-size: 65%; background-position: -200px center;">

    <div class="container">
        <div class="row tp--col-sm-vertical-align">

            <div class="col-md-5 col-md-offset-6 text-center text-md-left">
                <h2>Every detail perfected for you</h2>
                <p>You can view all requests for next processing.</p>
                <p>We provide client device auth request logs and support system for resolving issues. </p>
               {{-- <a href="#">
                    <span class="btn btn-default btn-oval">More information</span>
                </a>--}}
            </div>

            <div class="col-sm-12 visible-sm visible-xs">
                <img src="{{url('frontend/images/devices/device-macbook-2.png')}}" class="img-responsive" alt="">
            </div>

        </div>
    </div>

</section>



<!-- Featured Sections
================================================== -->
<section id="featured3" class="tp--section tp--section-with-bg-overlay tp--featured tp--parallax text-xs-center p-top-md-200 p-bottom-md-200" style="background-image: url(frontend/images/bg-intro-3.jpg)">

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-5">
                <h2 class="title">Isolate system for your business</h2>
                <p>All security infrastructure can work at your isolate network system or data center. For more information <a href="{{route('support.ticket.create')}}">contact us</a>.</p>
            </div>
        </div>
    </div>

</section>



<!-- Pricing
================================================== -->






<!-- Extra Features Section
================================================== -->
<section id="features" class="tp--section tp--features text-left text-xs-center">

    <div class="page-header text-center tp--title-overlay">
        <h2 data-title="Features"><span>Extra Features</span></h2>
    </div>

    <div class="container">

        <div class="row">
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-server icon-small"></i>
                </div>
                <h3>API</h3>
                <p>Full REST API for integration with multiplatform authorization system. <a href="{{route('frontend.content.api')}}">show</a></p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-mobile-phone icon-small"></i>
                </div>
                <h3>More devices</h3>
                <p>Your client can have many watches, pads, phones or other devices for authorization.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-share-alt icon-small"></i>
                </div>
                <h3>Push routings</h3>
                <p>We provide "parent control" or order list for authorizations for many clients group.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-bell icon-small"></i>
                </div>
                <h3>Web-hooks</h3>
                <p>We send web http-requsts to your server about authorization push events.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-thumbs-o-up icon-small"></i>
                </div>
                <h3>FREE for small office</h3>
                <p>Its free for small client groups.</p>
            </div>
            <div class="col-sm-4 tp--feature">
                <div class="tp--icon-wrapper">
                    <i class="tp--icon-gradient fa fa-lock icon-small"></i>
                </div>
                <h3>Security</h3>
                <p>Only TLS with HMAC signature and valid data.</p>
            </div>
        </div><!-- /.row -->
    </div>

</section>



<!-- Call to Action
================================================== -->
<section class="tp--section tp--cta tp--cta-2 tp--section-light">

    <div class="container">

        <div class="row tp--col-sm-vertical-align">

            <div class="col-sm-7 col-sm-offset-1">
                <h2 class="title">Enjoy the project for free</h2>
                <p>Sign up to get started with your free account.</p>
            </div>
            <div class="col-sm-3">

                <p><a href="{{route('login')}}" class="btn btn-primary btn-lg ">Get started</a></p>
            </div>

        </div>

    </div>

</section>

@include('frontend.layout.footer')

{!! Html::script('assets/js/highlight/highlight.pack.js') !!}

<script>
    $(document).ready(function() {
        'use strict';
        $('pre code').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    });
    </script>