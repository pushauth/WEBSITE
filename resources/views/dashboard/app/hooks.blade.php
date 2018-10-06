@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}
{!! Html::style('assets/css/bootstrap-switch.css') !!}
{!!  Html::style('assets/css/switchery.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">Application - {{$app->name}}</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">





                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.app.appinfo')








                            @include('dashboard.app.menu')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Web Hooks</h2>
<hr>
                            @include('dashboard.layout.result_msg')


                            @if(Session::has('test-result-ok'))
                                <hr>
                                <div class="bg-success padding-sm">
                                    <div class="row">

                                        <div class="col-md-6">

                                            Data: <pre style="font-size: 10px">{{ print_r(Session::get('test-result-ok.data'),true) }}</pre>

                                        </div>
                                        <div class="col-md-6">
                                            <p>We send test data with <strong>POST</strong> method and Content-Type
                                                <strong>
                                                @if (Session::get('test-result-ok.ctype') == 'json') Application/json
                                                @elseif(Session::get('test-result-ok.ctype') == 'form') Application/x-www-form-urlencoded
                                                @endif
</strong>
                                                to your Payload URL.</p>
                                            <p>Response with code:  <strong>{{ Session::get('test-result-ok.code') }}</strong></p>
                                            <p>Response with message:  <strong>{{ Session::get('test-result-ok.phrase') }}</strong></p>

                                        </div>

                                    </div>



                                </div>
                                <hr>
                            @endif

                            @if(Session::has('test-result-error'))
                                <hr>
                                <div class="bg-danger padding-sm">
                                    <div class="row">

                                        <div class="col-md-6">

                                            Data: <pre style="font-size: 10px">{{ print_r(Session::get('test-result-error.data'),true) }}</pre>

                                        </div>
                                        <div class="col-md-6">
                                            <p>We send test data with  <strong>POST</strong> method and Content-Type  <strong>@if (Session::get('test-result-error.ctype') == 'json') Application/json @elseif(Session::get('test-result-error.ctype') == 'form') Application/x-www-form-urlencoded  @endif</strong> to your Payload URL.</p>
                                            <p>Response with code:  <strong>{{ Session::get('test-result-error.code') }}</strong></p>
                                            <p>Response with message:  <strong>{{ Session::get('test-result-error.phrase') }}</strong></p>

                                        </div>

                                    </div>



                                </div>
                                <hr>
                            @endif







                           {{-- <div class="alert alert-theme alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Limits!</strong> Upgrade your Price Plan for available web hooks.
                            </div>--}}

<p>
    You can use Web hooks service. After client actions on mobile app, we send POST request to your server.<br>
    For more information read <a href="{{route('frontend.content.api')}}">API documentation</a>.
</p>
<hr>





                            {!! Form::model($app->hook,array('route' => ['app.hooks.update', $app->urlhash], 'autocomplete'=>'off')) !!}



                            <div class="form-group @if ($errors->has('payload_url')) has-error @endif">
                                <div class="row">
                                <div class="col-md-12" ><label for="payload_url">Payload URL *</label></div>
                                <div class="col-md-10" >{!! Form::text('payload_url', null, array('class'=>'form-control',
                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'http://example.com/hook')) !!} <p class="help-block">URL of service to receive data.</p>
                                    @if ($errors->has('payload_url')) <p class="help-block">{{ $errors->first('payload_url') }}</p> @endif


                                </div><div class="col-md-2" ><button name="btn" value="test" type="submit" class="btn btn-block btn-default ">Test</button></div></div>




                            </div>


                           {{-- <div class="form-group @if ($errors->has('retry')) has-error @endif @if ($errors->has('retry_code')) has-error @endif">
                                <div class="row">
                                    <div class="col-md-12" ><label for="retry">Retry times *</label></div>
                                    <div class="col-md-6" >
                                        {!! Form::select('retry', ['0'=>'No retry','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'],$app->hook->type, array('class'=>'form-control',
                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off')) !!}
                                        <p class="help-block">Maximum delay time before next retry is 5 sec.</p>
                                        </div>
                                    <div class="col-md-6" >
                                        {!! Form::text('retry_code', null, array('class'=>'form-control',
                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'For example: 200 or 500,404')) !!}
                                        <p class="help-block">PushAuth will stopped, when your server response this codes.</p>
                                    </div>
                                </div>
                                @if ($errors->has('retry')) <p class="help-block">{{ $errors->first('retry') }}</p> @endif
                                @if ($errors->has('retry_code')) <p class="help-block">{{ $errors->first('retry_code') }}</p> @endif
                                </div>--}}









                            <div class="form-group @if ($errors->has('ctype')) has-error @endif">
                                <label for="ctype">Content type</label>
                                {!! Form::select('ctype', ['json'=>'application/json','form'=>'application/x-www-form-urlencoded'],$app->hook->type, array('class'=>'form-control',
                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off')) !!}

                                @if ($errors->has('ctype')) <p class="help-block">{{ $errors->first('ctype') }}</p> @endif
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">

                                    {!! Form::checkbox('qr_flag','true',$qr_flag,['class'=>'switchery-success form-control' ]) !!}
                                    </div>
                                <label class="control-label col-sm-11" for="qrflag">QR-code <p class="help-block">Event, when client used QR-code from your site.</p></label>



                            </div>
                            <div class="form-group ">
                                <div class="col-sm-1">
                                    {!! Form::checkbox('push_flag','true',$push_flag,['class'=>'switchery-success form-control' ]) !!}


                                </div>
                                <label class="control-label col-sm-11" for="pushrequestflag">Push requests  <p class="help-block">Event, when client answer "yes" or "no" on Push in mobile application.</p></label>



                            </div>
                            <div class="form-group ">
                                <div class="col-sm-1">
                                    {!! Form::checkbox('timeout_flag','true',$timeout_flag,['class'=>'switchery-success form-control' ]) !!}

                                </div>
                                <label class="control-label col-sm-11" for="timeoutflag">Push requests timeout <p class="help-block">Event, when Push request expired, (after 30 second user has no action in mobile app)</p></label>



                            </div>



                            <div class="form-group ">


                                <div class="col-sm-1"> {!! Form::checkbox('status', 'enable',$status,['data-off-text'=>'No', 'data-on-text'=>'Yes', 'data-inverse'=>'true', 'class'=>'bootstrap-switch  form-control', 'data-size'=>'mini', 'data-on-color'=>'success']) !!}</div>
                                <label class="control-label col-sm-11" for="timeout">Enable </label>









                            </div>



                            <div class="row">
                                <div class="col-md-12"><hr></div>

                                <div class="col-md-2 col-md-offset-5">

                                    <button type="submit" name="btn" value="save" class="btn btn-block btn-success btn-lg">Save</button>

                                </div>
                            </div>

{!! Form::close() !!}


                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
{!! Html::script('assets/js/switchery.js') !!}
{!! Html::script('assets/js/bootstrap-switch.js') !!}
<script>
    $(document).ready(function() {
        'use strict';
        $(".bootstrap-switch").bootstrapSwitch();
        /*new Switchery(
                document.querySelector('.switchery-success'), {color: '#75c181', size: 'small' }
        );*/
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-success'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, {color: '#75c181', size: 'small' });
        })
    });
</script>