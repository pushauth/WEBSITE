@include('frontend.layout.head')

{!! Html::style('assets/css/bootstrap-switch.css') !!}
{!!  Html::style('assets/css/switchery.css') !!}
{!!  Html::style('assets/js/highlight/styles/zenburn.css') !!}
@include('frontend.layout.loaders')
@include('frontend.layout.nav')

<style>
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-success, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-success {
        color: #fff;
        background: #e07fc1;
    }
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
        color: #fff;
        background: #e07fc1;
    }
</style>

<!-- Inner Page Header
    ================================================== -->
<section class="tp--inner-header tp--section tp--section-dark tp--gradient-3 tp--pattern-1 tp--height-50 text-center">

    <div class="container tp--vertical-align">

        <div class="row">

            <div class="col-xs-12">

                <h2>Example Auth</h2>
                <p>We show how it works</p>

            </div>

        </div>

    </div>

</section>


<!-- Call to Action
================================================== -->
<section class="tp--section tp--cta tp--cta-2 tp--section-light">

    <div class="container">

        <div class="row tp--col-sm-vertical-align">


            <div class="col-md-6 col-md-offset-3">



                <div id="" class="tp--authentication text-center ">

                    <section class="tp--authentication-container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-header">
<h3>1. Install mobile application</h3>
                                    <p>
                                        <br>
                                        <a href="https://itunes.apple.com/vn/app/push-auth/id1242326600?mt=8">
                                        <img style=" width: 150px" src="{{url('frontend/images/apple-store-badge.png')}}">
                                            </a>
                                        <a href="https://play.google.com/store/apps/details?id=com.vladyslav.pushauth">
                                        <img style=" width: 150px" src="{{url('frontend/images/google-play-badge.png')}}">
                                            </a>
                                    </p>
                                    </div>
                                <hr>
                            </div>

                            </div>

                        <div class="page-header">
                            <h3>2. Check login authorization</h3>
                        </div>

                        <div class="row">

                            <div class="col-md-12">


                                    {!! Form::open(array('route' => 'appStore', 'autocomplete'=>'off', 'method'=>'PATCH', 'id'=>'pushauth-form','class'=>'form-authentication')) !!}


                                    <div class="row tp--social-login">

                                        <div id="response"></div>

                                        <div class="form-group ">


                                            <div class="col-sm-12 text-center"> {!! Form::checkbox('mode', 'enable','push',['data-off-text'=>'Code', 'data-on-text'=>'Request', 'id'=>'mode', 'data-inverse'=>'false', 'class'=>'bootstrap-switch  form-control', 'data-size'=>'big', 'data-on-color'=>'success']) !!}</div>
                                        </div>

                                    </div>

                                <div class="form-group @if ($errors->has('email')) has-error @endif">
                                    <i class="icon-envelope"></i>
                                    {!! Form::text('email', null, array('class'=>'form-control',
                                 'autocorrect'=>'off', 'id'=>'UIEmailL', 'type'=>'email', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Enter your email (from mobile app)')) !!}

                                    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                </div>



                                <div id="UICodeL" style="display: none;" class="form-group @if ($errors->has('code')) has-error @endif">
                                    <i class="fa fa-lock"></i>
                                    {!! Form::text('code', null, array('class'=>'form-control','id'=>'UICodeField',
                                 'autocorrect'=>'off', 'type'=>'code', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Enter code from push...')) !!}

                                    @if ($errors->has('code')) <p class="help-block">{{ $errors->first('code') }}</p> @endif
                                </div>

                                <input type="hidden" id="req_hash" value="">





<button id="UIbtn" class="btn button" name="commit" type="submit"><i id="UIbtnIcon" class="fa fa-sign-in"></i>
    <span id="UIbtnText"> Sign In</span></button>
                                    {{--<input id="UIbtn" class="button" name="commit" type="submit" value="Login">--}}

                                    <div class="tp--authentication-footer">
                                        <p class="links clearfix">

                                        </p>
                                    </div>

                                {!! Form::close() !!}

                            </div>

<hr>
                        </div>
                        <div class="page-header">

                            <h3>Or <br> scan QR-code</h3>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <img src="{{$qr}}" class="img-responsive" >


                                </div>
                            </div>

                    </section>

                </div>




            </div>

        </div>

    </div>

</section>

<section id="about" class="tp--section tp--features text-center">

    <div class="page-header text-center tp--title-overlay">
        <h2 data-title="server side"><span>How it works</span></h2>
    </div>

    <div class="container">

        <div class="row">

<div class="col-md-6 text-left">
<h4 class="text-center">Push Request</h4>
     <pre><code class="php">&lt;?php
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
            <div class="col-md-6 text-left">
                <h4 class="text-center">Code Request</h4>
     <pre><code class="php">&lt;?php
$req = $authRequest->to('client@example.com')
            ->mode('code')
            ->code('123456')
            ->send();

//Save $req (unique request hash) in your storage with code '123456'

if ($_REQUEST('client_code') == '123456') {
             echo "You are logged in...";
             }
else {
             echo "Access denied!";
             }</code></pre>
<p>View tutorials for more...</p>

            </div>



        </div><!-- /.row -->
    </div>

</section>

@include('frontend.layout.footer')
{!! Html::script('assets/js/switchery.js') !!}
{!! Html::script('assets/js/bootstrap-switch.js') !!}
{!! Html::script('assets/js/highlight/highlight.pack.js') !!}

<script>
    $(document).ready(function() {
        'use strict';
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });


        /*TODO some code to check QR {{$hash}}*/

        function checkQR(){
            $.ajax({
                type: "POST",
                url: "{{route('frontend.example.qr') }}",
                data: {
                    _token: CSRF_TOKEN,
                    hash: '{{$hash}}'
                },
                success: function (data) {
                    if (data.code == '200') {
                        window.location = data.url;
                    }

                },
                error :function( jqXhr ) {
                    if (jqXhr.status === 422) {
                        console.log('Must update QR code');
                    }
                }
            });

        }

        setInterval(checkQR,5000);


        $(".bootstrap-switch").bootstrapSwitch();

        var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-success'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, {color: '#75c181', size: 'small' });
        })


        $('#pushauth-form').submit(function (event) {
            var $form = $(this);
            event.preventDefault();

            //$("#req_hash").attr('value','');

            $("#UIbtn").addClass('disabled').attr('disabled','disabled');
            $("#UIbtnText").text('Just one moment...');
            $("#UIbtnIcon").removeClass().addClass('fa fa-circle-o-notch fa-spin fa-fw');

            $("#mode").bootstrapSwitch('disabled',true);
/*
            if ($("#mode").bootstrapSwitch('state') == false) {
                $("#UICodeL").fadeIn( 400);
            } else{
                $("#UICodeL").fadeOut( 400);
            }
*/



            $.ajax({
                type: "POST",
                url: "{{route('frontend.example.send') }}",
                data: {
                    _token : CSRF_TOKEN,
                    to : $("#UIEmailL").val(),
                    req_hash : $("#req_hash").val(),
                    code : $("#UICodeField").val(),
                    mode : $("#mode").bootstrapSwitch('state')



                },
                error :function( jqXhr ) {
                    if( jqXhr.status === 422 ) {
                        //process validation errors here.
                        var errors = jqXhr.responseJSON;
                        var errorsHtml;
                   /* <div class="alert alert-theme alert-danger alert-dismissible" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                         <strong>Oh snap!</strong> Change a few things up and try submitting again.
                         </div>*/
                        errorsHtml = '<div class="alert alert-theme alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';

                        $.each( errors , function( key, value ) {
                            errorsHtml += value[0]; //showing only the first error.
                            //errorstr+=value[0] + '';
                        });
                        errorsHtml += '</div>';

                        $("#response").html('').append(errorsHtml);;
                        $("#mode").bootstrapSwitch('disabled',false);
                        $("#UIbtn").removeClass('disabled').removeAttr('disabled');
                        $("#UIbtnText").text('Sign In');
                        $("#UIbtnIcon").removeClass().addClass('fa fa-sign-in');


                    }
                    if( jqXhr.status === 408 ) {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml, errorstr;
                        errorsHtml = '<div class="alert alert-theme alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
                        errorstr='';
                        $.each( errors , function( key, value ) {
                            errorsHtml += value[0] + ''; //showing only the first error.
                            errorstr+=value[0] + '';
                        });
                        errorsHtml += '</div>';
                        $("#response").html('');
                        $("#response").append(errorsHtml);
                        $("#UIbtn").removeClass('disabled').removeAttr('disabled');
                        $("#UIbtnText").text('Sign In');
                        $("#UIbtnIcon").removeClass().addClass('fa fa-sign-in');
                    }

                },
                success: function(data) {
                    $("#response").html('');
                    if (data.code == 'required') {

                        $("#req_hash").attr('value', data.req_hash);

                        $("#UIEmailL").fadeOut( 400);
                        $(".icon-envelope").fadeOut(400);
                        $("#UICodeL").fadeIn( 400);
                        $("#UICodeField").focus();
                        $("#UIbtn").removeClass('disabled').removeAttr('disabled');
                        $("#UIbtnText").text('Send code');
                        $("#UIbtnIcon").removeClass().addClass('fa fa-sign-in');

                    }
                    else{
                        //$("#response").append(data.url);
                        window.location = data.url;
                    }






                }
            });







            return false;
        });





    });
</script>