@include('dashboard.layout.header')

{!! Html::style('assets/css/jasny-bootstrap.css') !!}
{!! Html::style('assets/css/bootstrap-tagsinput.css') !!}
{!! Html::style('assets/css/bootstrap-switch.css') !!}
{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/member.css') !!}
{!!  Html::style('assets/css/project.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')




<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Push Request</h2>


        <div id="masonry" class="row">
            <div class="col-wrapper col-md-3 ">
                <div class="module-wrapper">
                    <section class="module member-module module-no-heading module-no-footer">
                        <div class="module-inner">
                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    <div class="profile">
                                        <span class="fa fa-comment fa-6" style="font-size: 100px;"></span>
                                    </div>



                                    <hr>

                                    {{-- <ul class="meta-data list-unstyled">
                                         <li><span aria-hidden="true" class="icon icon icon_id"></span> Full-stack Developer</li>
                                         <li><span aria-hidden="true" class="icon icon_pin_alt"></span> San Francisco, CA</li>
                                         <li><span aria-hidden="true" class="icon icon_mail_alt"></span> david.t@website.com</li>
                                         <li><span aria-hidden="true" class="icon icon_clock_alt"></span> 18 July 2015</li>
                                     </ul>--}}
                                    <div class="contact">

                                        <a href="{{route('admin.delete.push',$push->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                    {{--<hr>
                                    <div class="data-overview">
                                        <ul class="list-inline text-center">
                                            <li class="projects"><span class="figure">6</span><span>projects</span></li>
                                            <li class="discussions"><span class="figure">12</span><span>discussions</span></li>
                                            <li class="commits"><span class="figure">673</span><span>commits</span></li>
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="social-media">
                                        <ul class="list-inline text-center">
                                            <li><a href="#" class="twitter-btn"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="#" class="google-btn"><i class="fa fa-google-plus"></i></a></li>
                                            <li><a href="#" class="facebook-btn"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="#" class="github-btn"><i class="fa fa-github-alt"></i></a></li>
                                        </ul>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>


            <div class="col-wrapper col-md-9 ">

                <section class="module module-no-heading module-no-footer">
                    <div class="module-inner">
                        <div class="module-content">
                            <div class="module-content-inner no-padding-bottom">


                                @include('dashboard.layout.result_msg')



                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-tabs-theme-3" role="tablist">
                                        <li role="presentation" class="active"><a href="#home-7" aria-controls="home-7" role="tab" data-toggle="tab"><span class="fa fa-info" aria-hidden="true"></span><br><span class="hidden-xs hidden-sm">Info</span></a></li>
                                        <li class="last" role="presentation"><a href="#settings-7" aria-controls="settings-7" role="tab" data-toggle="tab"><span class="fa fa-cog" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Settings</span></a></li>
                                        {{--<li role="presentation"><a href="#profile-7" aria-controls="profile-7" role="tab" data-toggle="tab"><span class="fa fa-comment" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Pushes</span></a></li>

                                        <li role="presentation"><a href="#messages-7" aria-controls="messages-7" role="tab" data-toggle="tab"><span class="fa fa-cube" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Apps</span></a></li>

                                        --}}
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home-7">
                                            <div class="meta-data">
                                                <dl class="dl-horizontal">



                                                    <dt>App:</dt>
                                                    <dd>{{$push->app->name}}</dd>
                                                    <dt>Device:</dt>
                                                    <dd>{{$push->device->token}} / {{$push->device->user->name}}</dd>
                                                    <dt>Hash request:</dt>
                                                    <dd>{{$push->hash}}</dd>
                                                    <dt>Mode:</dt>
                                                    <dd>
                                                        @if ($push->mode == 'code') <span class='label label-normal'>code</span>@elseif($push->mode == 'push') <span class='label label-critical'>push</span>  @endif


                                                    </dd>
                                                    <dt>Answer:</dt>
                                                    <dd>

                                                        @if ($push->mode == 'code')
                                                        <span class='label label-review'>OK</span>
                                                        @elseif ($push->mode == 'push')

                                                        @if ($push->answer == Null)
                                                        <span class='label label-progress'>no answer</span>
                                                        @else
                                                        @if ($push->answer == 'true')
                                                        <span class='label label-open'>YES</span>
                                                        @else
                                                        <span class='label label-closed'>NO</span>
                                                        @endif
                                                        @endif
                                                        @endif


                                                    </dd>
                                                    <dt>Response at:</dt>
                                                    <dd>@if($push->response_dt <> null) {{$push->response_dt->format('l jS \\of F Y H:i:s ')}}@endif</dd>

                                                    <dt>Response code:</dt>
                                                    <dd>{{$push->response_code}}</dd>
                                                    <dt>Response code:</dt>
                                                    <dd>{{$push->response_message}}</dd>
                                                    <dt>Mode_code:</dt>
                                                    <dd>{{$push->code}}</dd>


                                                    <dt>Created at:</dt>
                                                    <dd>{{$push->created_at->format('l jS \\of F Y H:i:s ')}}</dd>
                                                </dl>



                                            </div>




                                        </div>

                                       {{-- <div role="tabpanel" class="tab-pane" id="profile-7">
                                            <div class="meta-data">

                                                <div class="table-responsive">
                                                    <table id="datatables-2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>App</th>
                                                            <th>Mode</th>
                                                            <th>Result</th>
                                                            <th>Hash</th>
                                                            --}}{{--<th class="no-sort">Show</th>
                                                            <th class="no-sort">Destroy</th>--}}{{--
                                                        </tr>
                                                        </thead>
                                                        <tbody style="
    font-size: 13px;
"></tbody>

                                                        <tbody>



                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
--}}
                                        {{--<div role="tabpanel" class="tab-pane" id="messages-7">




                                            <div class="table-responsive">
                                                <table id="datatables-1" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Pushes</th>
                                                        <th>Devices</th>
                                                        <th>User</th>
                                                        <th>Status</th>
                                                        --}}{{-- <th class="no-sort">Config</th>
                                                         <th class="no-sort">Destroy</th>--}}{{--
                                                    </tr>
                                                    </thead>
                                                    <tbody style="
    font-size: 13px;
"></tbody>

                                                    <tbody>



                                                    </tbody>
                                                </table>
                                            </div>




                                        </div>--}}

                                        <div role="tabpanel" class="tab-pane" id="settings-7">






                                            {!! Form::model($push,array('route' => ['admin.update.push', $push->id], 'autocomplete'=>'off', 'files'=> true)) !!}


                                            <fieldset class="fieldset">

                                                <div class="form-group @if ($errors->has('hash')) has-error @endif">
                                                    <label class="control-label" for="hash">HASH *</label>

                                                    {!! Form::text('hash', null, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('hash')) <p class="help-block">{{ $errors->first('hash') }}</p> @endif

                                                </div>

                                                <div class="form-group @if ($errors->has('response_code')) has-error @endif">
                                                    <label class="control-label" for="response_code">Response code</label>

                                                    {!! Form::text('response_code', null, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('response_code')) <p class="help-block">{{ $errors->first('response_code') }}</p> @endif

                                                </div>

                                                <div class="form-group @if ($errors->has('response_dt')) has-error @endif">
                                                    <label class="control-label" for="response_dt">Response DT</label>

                                                    {!! Form::text('response_dt', null, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('response_dt')) <p class="help-block">{{ $errors->first('response_dt') }}</p> @endif

                                                </div>


                                                <div class="form-group @if ($errors->has('mode')) has-error @endif">
                                                    <label class="control-label" for="mode">Mode *</label>

                                                    {!! Form::select('mode',['code'=>'code','push'=>'push'] ,$push->mode, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('mode')) <p class="help-block">{{ $errors->first('mode') }}</p> @endif

                                                </div>

                                                <div class="form-group @if ($errors->has('code')) has-error @endif">
                                                    <label class="control-label" for="code">Code</label>

                                                    {!! Form::text('code', null, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('code')) <p class="help-block">{{ $errors->first('code') }}</p> @endif

                                                </div>

                                                <div class="form-group @if ($errors->has('answer')) has-error @endif">
                                                    <label class="control-label" for="answer">Answer</label>

                                                    {!! Form::select('answer',['true'=>'true','false'=>'false'] ,$push->answer, array('class'=>'form-control', 'placeholder'=>'empty')) !!}
                                                    @if ($errors->has('answer')) <p class="help-block">{{ $errors->first('answer') }}</p> @endif

                                                </div>
</fieldset>




                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <button type="submit" class="btn btn-block btn-success btn-lg">Save</button>
                                                </div>
                                            </div>




                                            {!! Form::close() !!}





                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
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

{!! Html::script('assets/js/bootstrap-tagsinput.js') !!}
{!! Html::script('assets/js/bootstrap-switch.js') !!}



<script>
    $(document).ready(function() {
        'use strict';
        $(".bootstrap-switch").bootstrapSwitch();



    });

</script>