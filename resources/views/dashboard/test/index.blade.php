@include('dashboard.layout.header')

{!! Html::style('assets/css/bootstrap-switch.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Test app</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-6">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Request PushAuth</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">


                                <form class="form-horizontal" data-parsley-validate="">




                                    <div class="form-group">
                                        <label for="mode" class="col-sm-3 control-label">App</label>

                                        <div class="col-sm-9">
                                            <select id="appHash" class="form-control">
                                                @foreach( $user->app as $app)
                                                <option value="{{$app->urlhash}}"
                                                @if ($urlhash == $app->urlhash) selected @endif
                                                >{{$app->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="option-divider"><span>Options</span></div>
                                    <div class="form-group">
                                        <label for="to" class="col-sm-3 control-label">To</label>
                                        <div class="col-sm-4">
                                            {!! Form::checkbox('to', 'enable',null,['data-off-text'=>'Mobile', 'data-size'=>'small', 'id'=>'to', 'data-on-text'=>'Local','checked', 'class'=>'bootstrap-switch form-control']) !!}
                                        </div>

                                        <div class="col-sm-5">
                                            <input type="email" id="to_field" class="form-control" placeholder="Email of client device">
                                        </div>


                                    </div>


                                    <div class="form-group">
                                        <label for="mode" class="col-sm-3 control-label">Push mode</label>
                                        <div class="col-sm-4">
                                            {!! Form::checkbox('mode', 'enable',null,['data-off-text'=>'Code','checked', 'data-size'=>'small', 'data-on-text'=>'Push', 'id'=>'mode', 'class'=>'bootstrap-switch form-control']) !!}
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="modeText" data-parsley-length="[1,8]" placeholder="Some code" disabled>
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label for="wait_response" class="col-sm-3 control-label">Wait response</label>

                                        <div class="col-sm-9">
                                            {!! Form::checkbox('response', 'enable',null,['data-off-text'=>'No', 'data-size'=>'small', 'data-on-text'=>'Yes', 'class'=>'bootstrap-switch form-control', 'id'=>'wait_response']) !!}
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-7">
                                            <button type="button" id="sendTest" validate class="btn btn-pink"><i class="fa fa-play-circle"></i>  Send Request</button>

                                        </div>
                                    </div>


                                </form>
                                <div class="option-divider"><span>Check Push Answer</span></div>


                                <form class="form-horizontal" data-parsley-validate="">
                                <div class="form-group">




                                    <label for="pr" class="col-sm-3 control-label">Push Request Hash</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="pr">
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" id="UICheckStatus" class="btn btn-default"><i class="fa fa-check"></i>Check answer!</button>
                                    </div>






                                </div>
                                </form>
                                <div class="option-divider"><span>Console log</span></div>
                                <div class="well">
                                    <div id = "serverLog">
                                        <span class="text-stronger">Ready for Request</span>

                                    </div>
                                </div>

                            </div></div>

                    </div>
                </section>
            </div>
            <div class="module-wrapper masonry-item col-md-6">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Web device emulator</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">



                                <div id="msg" class="alert alert-theme alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <strong>Howdy!</strong> Waiting Push...
                                </div>



                                <div id="msgPush" class="panel panel-default" style="display: none;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" id="UImsgPushTitle">[YourApp] request auth!</h3>
                                    </div>
                                    <div class="panel-body" >
                                      <center id="UImsgPushBody">  <strong>Well done!</strong>
                                          You receive new PushAuth!<br>

                                          Do you want to Auth?




                                      </center>

                                        <div class="row">
                                            <div class="col-md-12">
                                        <center><div class="timer text-center"></div><br><br><br></center>
                                            </div>
                                        </div>

                                        <br>
                                        <center id="UImsgPushActions">
                                        <button type="button" class="btn btn-success-alt UImsgPushAction" data-flag="true">YES</button>

                                        <button type="button"  class="btn btn-danger-alt UImsgPushAction" data-flag="false">NO</button>
                                            </center>
                                    </div>
                                </div>

                                {{--
                                <div class="alert alert-success alert-theme-solid alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <strong>Well done!</strong> You receive new PushAuth!<br> Do you want to Auth?<br>


                                    <button type="button" class="btn btn-success-alt">Success Button</button>

                                    <button type="button" class="btn btn-success-alt">Success Button</button>
                                </div>--}}



                                <div class="option-divider"><span>Console log</span></div>
                                {{--<div class="well">
                                    <span class="text-stronger">NOTICE:</span>Device wait your Push...
                                <br>A finance charge of 2.5% will be made on unpaid balances after 30 days.
                                    <br>A finance charge of 2.5% will be made on unpaid balances after 30 days.
                                </div>--}}

                            </div></div>

                    </div>
                </section>




            </div>
            {{--<div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">How it works?</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">

                                This test app service working via [ Web browser JQuery ] -> [ PushAuth Server ] -> [ core ] -> [ client device ].
                                And after answering, [ client device ] -> [ PushAuth Server ] -> [ Web browser JQuery ]. This service emulate user authentification on your App/service and return his answer.


                                </div>
                            </div>
                        </div>
                    </section>
                </div>--}}









        </div>






    </div>
</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

{!! Html::script('assets/js/bootstrap-switch.js') !!}

{!! Html::script('assets/js/circular-countdown.min.js') !!}

<script>
    $(document).ready(function() {

        var msgVisible = false;

        $(".bootstrap-switch").bootstrapSwitch();
        $('#to_field').prop('disabled', true);

        $("#UICheckStatus").prop('disabled', true);
        $("#pr").prop('disabled', true);

        $('#to').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state == true) {
                $('#to_field').prop('disabled', true);
                $("#wait_response").bootstrapSwitch('state', false);
                $("#wait_response").bootstrapSwitch('disabled',true);
                $("#UICheckStatus").prop('disabled', true);
                $("#pr").prop('disabled', true);

            }
            else {
                $('#to_field').prop('disabled', false);

                if ($('#mode').bootstrapSwitch('state') == true) {
                    $("#UICheckStatus").prop('disabled', false);
                    $("#pr").prop('disabled', false);
                }

                $("#wait_response").bootstrapSwitch('disabled',false);



            }


        });

        $('#mode').on('switchChange.bootstrapSwitch', function (event, state) {
            if (state == true) {
                $('#modeText').prop('disabled', true);

                if ($('#to').bootstrapSwitch('state') == false) {
                    $("#wait_response").bootstrapSwitch('disabled', false);
                    $("#UICheckStatus").prop('disabled', false);
                    $("#pr").prop('disabled', false);

                }
            }
            else {
                $('#modeText').prop('disabled', false);
                //$("#wait_response").bootstrapSwitch('disabled', true);
                $("#wait_response").bootstrapSwitch('state', false);
                $("#wait_response").bootstrapSwitch('disabled', true);
                if ($('#to').bootstrapSwitch('state') == false) {
                    $("#UICheckStatus").prop('disabled', true);
                    $("#pr").prop('disabled', true);
                }
            }


        });







        
/*        function check_to() {




            if ($('#to').bootstrapSwitch('state') == false) {

                if (isEmail($('#to_field').val()) == false) {

                    $("#serverLog").append('<br>Address TO must be valid email!');
                    $('#to_field').addClass('parsley-error');

                    return false;

                }

                $('#to_field').removeClass('parsley-error');
                return true;

            }

            $('#to_field').removeClass('parsley-error');
            return true;
        }*/

        $('body').on('click', '#UICheckStatus', function(event) {
            event.preventDefault();
            var devices = $("#pr").val();
            $.ajax({
                type: "POST",
                url: "{{route('testAppStatus') }}",
                data: {
                    _token : CSRF_TOKEN,
                    devices : devices


                },
                error :function( jqXhr ) {
                    if( jqXhr.status === 422 ) {
                        //process validation errors here.
                        var errors = jqXhr.responseJSON;

                        errorsHtml = '<div class="text-danger">';
                        errorstr='';
                        $.each( errors , function( key, value ) {
                            errorsHtml += value[0] + '<br>'; //showing only the first error.
                            errorstr+=value[0] + '<br>';
                        });
                        errorsHtml += 'Stopped! </div>';
                        $("#serverLog").append(errorsHtml);
                        $.notify('<i class="fa fa-frown-o"></i> '+ errorstr, {
                            style: 'appkit',
                            className: 'error',
                            //autoHide: false,
                            //clickToHide: true,
                            hideAnimation: 'fadeOut',
                            showAnimation: 'fadeIn'
                        });

                    }

                },
                success: function(data) {




                    $("#serverLog").append(data.msg);
                    $.notify('<i class="fa fa-check"></i>  ' + data.msg, {
                        style: 'appkit',
                        className: 'success',
                        hideAnimation: 'fadeOut',
                        showAnimation: 'fadeIn'
                    });


                }
            });


        });



        //UImsgPushAction
        $('body').on('click', '.UImsgPushAction', function(event) {
            event.preventDefault();
            var flag = $(this).data('flag');


            $('.timer').html('');


            $("#msgPush").hide();
            $("#serverLog").html('App send answer: '+ flag);
            $.notify('<i class="fa fa-check"></i>  App send answer: '+ flag, {
                style: 'appkit',
                className: 'success',
                hideAnimation: 'fadeOut',
                showAnimation: 'fadeIn'
            });


            //console.log(flag);

        });

        $('body').on('click', '#sendTest', function(event) {
            event.preventDefault();

            $("#serverLog").html('Sending request to server...');





           // if (check_to()) {

                var hash = $("#appHash").val();
                var to = $('#to').bootstrapSwitch('state');

                var to_field = $('#to_field').val();


                var mode = $('#mode').bootstrapSwitch('state');
                var code = $('#modeText').val();

                var wait_response =  $('#wait_response').bootstrapSwitch('state');

            if (wait_response == true) {
                $("#serverLog").append('Waiting 30 second to response from device...<br>');
                $.notify('<i class="fa fa-check"></i>  Waiting 30 second for response...', {
                    style: 'appkit',
                    className: 'success',
                    hideAnimation: 'fadeOut',
                    showAnimation: 'fadeIn'
                });
            }
                //console.log(hash);


            if (to == true) {

                var appName = $('#appHash option:selected').text();


                $("#msg").hide();
                $("#msgPush").hide();
                //$('.timer').circularCountDown().destroy();


                $("#UImsgPushTitle").html(appName + ' request push auth!');

                if (mode == true) {
                    $("#UImsgPushBody").html('<strong>Well done!</strong> You receive new PushAuth!<br> Do you want to Auth?');
                    $("#UImsgPushActions").show();

                } else {
                    $("#UImsgPushBody").html('<strong>Well done!</strong> You receive new PushAuth!<br> Your code: '+ code);
                    $("#UImsgPushActions").hide();

                }
                $('.timer').html('');

                $("#msgPush").show();
                $('.timer').circularCountDown({
                    delayToFadeIn: 500,
                    size: 100,
                    fontColor: 'black',
                    colorCircle: 'white',
                    background: '#2ECC71',
                    reverseLoading: false,
                    duration: {
                        seconds: 30
                    },
                    beforeStart: function() {
                        //$('.launcher').hide();
                        $("#msgPush").show();
                        msgVisible = true;
                    },
                    end: function(countdown) {
                        $("#msgPush").hide();
                        msgVisible = false;
                        countdown.destroy();
                        //$('.launcher').show();
                        //alert('terminé');
                    }
                });

                /*$('.timer').circularCountDown({
                    size: 60,
                    borderSize: 10,
                    colorCircle: 'gray',
                    background: 'white',
                    fontFamily: 'sans-serif',
                    fontColor: '#333333',
                    fontSize: 16,
                    delayToFadeIn: 0,
                    delayToFadeOut: 0,
                    reverseLoading: false,
                    reverseRotation: false,
                    duration: {
                        hours: 0,
                        minutes: 0,
                        seconds: 30
                    },
                    beforeStart: function(){
                        $("#msgPush").show();
                    },
                    end: function(){
                        $("#msgPush").hide();
                    }
                });*/







            }
            else {



                $.ajax({
                    type: "POST",
                    url: "{{route('testApp') }}",
                    data: {
                        _token : CSRF_TOKEN,
                        app_hash : hash,
                        to : to,
                        to_field: to_field,
                        mode: mode,
                        code: code,
                        wait_response: wait_response


                    },
                    error :function( jqXhr ) {
                        if( jqXhr.status === 422 ) {
                            //process validation errors here.
                            var errors = jqXhr.responseJSON;

                            errorsHtml = '<div class="text-danger">';
                            errorstr='';
                            $.each( errors , function( key, value ) {
                                errorsHtml += value[0] + '<br>'; //showing only the first error.
                                errorstr += value[0] + '<br>';
                            });
                            errorsHtml += 'Stopped! </div>';

                            $("#serverLog").append(errorsHtml);

                            $.notify('<i class="fa fa-frown-o"></i> '+ errorstr, {
                                style: 'appkit',
                                className: 'error',
                                //autoHide: false,
                                //clickToHide: true,
                                hideAnimation: 'fadeOut',
                                showAnimation: 'fadeIn'
                            });

                            }

                    },
                    success: function(data) {




                        $("#serverLog").append(data.msg);
                        $.notify(data.msg, {
                            style: 'appkit',
                            className: 'success',
                            hideAnimation: 'fadeOut',
                            showAnimation: 'fadeIn'
                        });


                    }
                });

            }

           // }



        });

        /*$('.bootstrap-switch').change(function() {
            if ($('#to').is(':checked') == true) {
                $('#to_field').prop('disabled', true);
            }
        });*/




    });
</script>