@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')




<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Price Plan edit</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Plan: {{$plan->name}} </h3>

                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">

                                @include('dashboard.layout.result_msg')







                                {!! Form::model($limits, array('route' => ['admin.plan.save',$plan->id], 'class'=>'form-horizontal', 'autocomplete'=>'off', 'method'=>'POST')) !!}

                                <fieldset class="fieldset">



                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="name">Name *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('name', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('pushes_day')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="pushes_day">Pushes per day *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('pushes_day', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('pushes_day')) <p class="help-block">{{ $errors->first('pushes_day') }}</p> @endif
                                        </div>
                                    </div>



                                    <div class="form-group @if ($errors->has('pushes_month')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="pushes_month">Pushes per month *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('pushes_month', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('pushes_month')) <p class="help-block">{{ $errors->first('pushes_month') }}</p> @endif
                                        </div>
                                    </div>


                                    <div class="form-group @if ($errors->has('logs_period')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="logs_period">Logs period *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::select('logs_period', ['day'=>'day','week'=>'week','month'=>'month','anytime'=>'anytime'],null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('logs_period')) <p class="help-block">{{ $errors->first('logs_period') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('apps')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="apps">Applications *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('apps', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('apps')) <p class="help-block">{{ $errors->first('apps') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('users')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="users">Users *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('users', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('users')) <p class="help-block">{{ $errors->first('users') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('devices')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="devices">Devices *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::text('devices', null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('devices')) <p class="help-block">{{ $errors->first('devices') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('routes')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="routes">Routes *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::select('routes', ['true'=>'true','false'=>'false'],null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('routes')) <p class="help-block">{{ $errors->first('routes') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('webhooks')) has-error @endif">
                                        <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="webhooks">WebHooks *</label>
                                        <div class="col-md-10 col-sm-9 col-xs-12">
                                            {!! Form::select('webhooks', ['true'=>'true','false'=>'false'],null, array('class'=>'form-control')) !!}
                                            @if ($errors->has('webhooks')) <p class="help-block">{{ $errors->first('webhooks') }}</p> @endif
                                        </div>
                                    </div>




                                    </fieldset>

                                <div class="form-group">
                                    <div class="col-md-10 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                        <input class="btn btn-primary" type="submit" value="Save">
                                    </div>
                                </div>

                                {!! Form::close() !!}











                                {{--<div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-theme alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Howdy!</strong> You have not any users.
                                        </div>
                                    </div>
                                </div>--}}





                            </div></div>

                    </div>
                </section>
            </div>
        </div>






    </div>
</div>



<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete App?</h4>
            </div>
            <div class="modal-body">
                Are you really want to delete App? Because your will never restored.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-alt" data-dismiss="modal">No</button>
                <button type="button" id="makeDeleteApp" data-app-hash="" class="btn btn-primary">Yes, i'm sure!</button>
            </div>
        </div>
    </div>
</div>





@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')





<script>
    $(document).ready(function() {
        'use strict';




    });

</script>