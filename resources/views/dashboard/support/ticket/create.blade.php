@include('dashboard.layout.header')

{!!  Html::style('assets/js/highlight/styles/tomorrow.css') !!}
{!!  Html::style('assets/css/bootstrap-datepicker.css') !!}




@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<style>

</style>







<div id="content-wrapper" class="content-wrapper view project-single-view" >
    <div class="container-fluid">
        <div class="project-heading">
            <h2 class="view-title">Request form</h2>
        </div>
        <div class="clearfix"></div>
        <div class="row" >

            <div class="col-wrapper col-md-12 col-sm-12 col-xs-12 " >
                <div class="module-wrapper " id="navs" data-spy="" data-offset-top="0" style="top: 10px;">
                    <section class="module commits-module " >
                        <div class="module-inner" >
                            <div class="module-heading">
                                <h3 class="module-title">Fill the form for request</h3>
                            </div>

                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">

                                    @include('dashboard.layout.result_msg')


                                        {!! Form::open(array('route' => 'support.ticket.store', 'autocomplete'=>'off', 'files'=> true, 'method'=>'PATCH', 'class'=>'form-horizontal')) !!}

                                        <div class="row">



                                            <div class="col-md-9">

                                                <div class="form-group @if ($errors->has('req_type')) has-error @endif">
                                                    <label for="req_type" class="col-sm-3 control-label">Request type *</label>
                                                    <div class="col-sm-9">
                                                    {!! Form::select('req_type', ['Technical'=>'Technical','Billing'=>'Billing','Partnership'=>'Partnership','Other'=>'Other'],[], array('class'=>'form-control', 'placeholder'=>'Select one...') )!!}
                                                    @if ($errors->has('req_type')) <p class="help-block">{{ $errors->first('req_type') }}</p> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group @if ($errors->has('subj')) has-error @endif">
                                                    <label for="subj" class="col-sm-3 control-label">Subject *</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::text('subj', Null, array('class'=>'form-control',
                                                     'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off')) !!}
                                                        @if ($errors->has('subj')) <p class="help-block">{{ $errors->first('subj') }}</p> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group @if ($errors->has('body')) has-error @endif">
                                                    <label for="body" class="col-sm-3 control-label">How can we help you? *</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::textarea('body', Null, array('class'=>'form-control',
                                                     'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off','rows'=>'3')) !!}
                                                        @if ($errors->has('body')) <p class="help-block">{{ $errors->first('body') }}</p> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mode" class="col-sm-3 control-label">App</label>

                                                    <div class="col-sm-9">
                                                        {!! Form::select('app_hash', $user->app()->lists('name','urlhash')->toArray() ,[], array('class'=>'form-control', 'placeholder'=>'-') )!!}

                                                    </div>

                                                </div>

                                                <div class="form-group @if ($errors->has('error_msg')) has-error @endif">
                                                    <label for="error_msg" class="col-sm-3 control-label">Error message</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::textarea('error_msg', Null, array('class'=>'form-control',
                                                     'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off','rows'=>'3')) !!}
                                                        @if ($errors->has('error_msg')) <p class="help-block">{{ $errors->first('error_msg') }}</p> @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3">Timeline issue</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group input-group-icon-click">
                                                            <input id="datepicker1" name="timeline" class="form-control" type="text" value="{{date('d-m-Y')}}">
                                                            <span class="input-group-addon"><i class="fa fa-calendar cursor-pointer"></i></span>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group  @if ($errors->has('files')) has-error @endif">
                                                    <label for="files" class="col-sm-3 control-label">Files</label>
                                                    <div class="col-sm-9">
                                                        {!! Form::file('files[]', array('class'=>'form-control','multiple'=>true)) !!}
                                                        @if ($errors->has('files')) <p class="help-block">{{ $errors->first('files') }}</p> @endif
                                                    </div>
                                                </div>






                                            </div>
                                            <div class="col-md-3">


                                                <blockquote>
                                                    <p>We answering to your request until 72h. But if you want fast answer, you can upgrade your Price Plan.</p>
                                                    <small>Also <cite title="Source Title">read manuals</cite></small>

                                                </blockquote>


                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <hr>
                                                    <button type="submit" class="btn btn-block btn-success btn-lg">Send request!</button>
                                                </div>
                                            </div>

                                        </div>


                                        {!! Form::close() !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>






            </div>
        </div>
    </div>
</div>







@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
{!! Html::script('assets/js/highlight/highlight.pack.js') !!}
{!! Html::script('assets/js/bootstrap-datepicker.js') !!}



<script>
    $(document).ready(function() {
        'use strict';
        $('#datepicker1').datepicker({
            todayBtn: "linked",
            calendarWeeks: true,
            format:"dd-mm-yyyy",
            autoclose: true,
            keyboardNavigation: false,
            todayHighlight: true
        });
    });

</script>

