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
        <h2 class="view-title">{{$app->name}}</h2>


        <div id="masonry" class="row">
            <div class="col-wrapper col-md-3 ">
                <div class="module-wrapper">
                    <section class="module member-module module-no-heading module-no-footer">
                        <div class="module-inner">
                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    <div class="profile">
                                        <img class="img-responsive" src="@if ($app->img == Null) {{route('app.logo.show', 'default_app.png') }} @else {{route('app.logo.show', $app->img) }} @endif" alt="">
                                    </div>



                                    <hr>

                                    {{-- <ul class="meta-data list-unstyled">
                                         <li><span aria-hidden="true" class="icon icon icon_id"></span> Full-stack Developer</li>
                                         <li><span aria-hidden="true" class="icon icon_pin_alt"></span> San Francisco, CA</li>
                                         <li><span aria-hidden="true" class="icon icon_mail_alt"></span> david.t@website.com</li>
                                         <li><span aria-hidden="true" class="icon icon_clock_alt"></span> 18 July 2015</li>
                                     </ul>--}}
                                    <div class="contact">

                                        <a href="{{route('admin.delete.app',$app->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
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

                                        <li role="presentation"><a href="#profile-7" aria-controls="profile-7" role="tab" data-toggle="tab"><span class="fa fa-comment" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Pushes</span></a></li>

                                        <li role="presentation"><a href="#messages-7" aria-controls="messages-7" role="tab" data-toggle="tab"><span class="fa fa-mobile" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Devices</span></a></li>

                                        <li class="last" role="presentation"><a href="#settings-7" aria-controls="settings-7" role="tab" data-toggle="tab"><span class="fa fa-cog" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Settings</span></a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home-7">
                                            <div class="meta-data">
                                                <dl class="dl-horizontal">


                                                    <dt>Enable:</dt>
                                                    <dd>@if($app->status == 'enable')<span class="label label-success">true</span>

                                                        @else <span class="label label-danger">false</span>

                                                        @endif</dd>
                                                    <dt>About:</dt>
                                                    <dd>{{$app->about}}</dd>
                                                    <dt>URL:</dt>
                                                    <dd>{{$app->url}}</dd>
                                                    <dt>IPs:</dt>
                                                    <dd>{{$app->ip_mask}}</dd>
                                                    <dt>Register:</dt>
                                                    <dd>{{$app->created_at->format('l jS \\of F Y H:i:s ')}}</dd>
                                                </dl>



                                            </div>




                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="profile-7">
                                            <div class="meta-data">

                                                <div class="table-responsive">
                                                    <table id="datatables-2" class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Device</th>
                                                            <th>Mode</th>
                                                            <th>Result</th>
                                                            <th>Hash</th>
                                                            {{--<th class="no-sort">Show</th>
                                                            <th class="no-sort">Destroy</th>--}}
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

                                        <div role="tabpanel" class="tab-pane" id="messages-7">



                                            <div class="table-responsive">
                                                <table id="datatables-3" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>UUID</th>
                                                        <th>Token</th>
                                                        <th>User</th>
                                                        <th>Pushes</th>
                                                        <th>Platform</th>
                                                        <th>Status</th>
                                                        {{--<th class="no-sort">Config</th>
                                                        <th class="no-sort">Destroy</th>--}}
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

                                        <div role="tabpanel" class="tab-pane" id="settings-7">






                                            {!! Form::model($app,array('route' => ['admin.app.update', $app->id], 'autocomplete'=>'off', 'files'=> true)) !!}


                                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                                <label for="name">Name *</label>
                                                {!! Form::text('name', null, array('class'=>'form-control',
                                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'ex. MyServiceApp')) !!}
                                                @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                            </div>

                                            <div class="form-group @if ($errors->has('about')) has-error @endif">
                                                <label for="about">About *</label>
                                                {!! Form::textarea('about', null, array('class'=>'form-control',
                                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'rows'=>'3', 'autocomplete'=>'off', 'placeholder'=>'ex. https://example.com/')) !!}
                                                @if ($errors->has('about')) <p class="help-block">{{ $errors->first('about') }}</p> @endif
                                            </div>

                                            <div class="form-group @if ($errors->has('url')) has-error @endif">
                                                <label for="url">URL</label>
                                                {!! Form::text('url', null, array('class'=>'form-control',
                                             'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'ex. https://example.com/')) !!}
                                                @if ($errors->has('url')) <p class="help-block">{{ $errors->first('url') }}</p> @endif
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group @if ($errors->has('app_img')) has-error @endif">
                                                    <label class="label-control">Logo</label>
                                                    <br>
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 80px;">

                                                            @if ($app->img == Null)
                                                                <img src="{{route('app.logo.show','default_app.png')}}">
                                                            @else
                                                                <img src="{{route('app.logo.show',$app->img)}}">
                                                            @endif



                                                        </div>
                                                        <div>
                                                            @if ($errors->has('app_img')) <p class="help-block">{{ $errors->first('app_img') }}</p> @endif
                                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>

                                                                {!! Form::file('app_img', ['id'=>'app_img']) !!}

													</span>
                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">




                                                <div class="form-group @if ($errors->has('ip_mask')) has-error @endif">
                                                    <label for="ip_mask">IP address white list</label>
                                                    <div class="row"><div class="col-md-12">
                                                            {!! Form::text('ip_mask', null, array('class'=>'form-control',
                                                         'autocorrect'=>'off', 'id'=>'ipmask', 'autocapitalize'=>'off','data-role'=>'tagsinput', 'autocomplete'=>'off', 'placeholder'=>'ex. 192.168.0.1')) !!}
                                                        </div></div>
                                                    <p class="help-block">If any IP-address setting, WhiteList will be enable.</p>
                                                    @if ($errors->has('ip_mask')) <p class="help-block">{{ $errors->first('ip_mask') }}</p> @endif
                                                </div>





                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group ">
                                                    <label for="status">Status Enable</label>
                                                    <div class="row"><div class="col-md-12">

                                                            {!! Form::checkbox('status', 'enable',$app->status,['data-off-text'=>'No', 'data-on-text'=>'Yes', 'class'=>'bootstrap-switch form-control']) !!}
                                                        </div></div>


                                                </div>


                                            </div>








                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <button type="submit" class="btn btn-block btn-success btn-lg">Save App!</button>
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



        $('#datatables-2').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            //"searchDelay": 500,
            "order": [[ 4, "desc" ]],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "ajax": {
                "url": "{{route('admin.ajax.pushes.app',$app->id)}}",
                "type": "POST"
            },
            "columns": [
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" }
            ]
        });


        $('#datatables-3').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            //"searchDelay": 500,
            "order": [[ 4, "desc" ]],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "ajax": {
                "url": "{{route('admin.ajax.app.devices',$app->id)}}",
                "type": "POST"
            },
            "columns": [
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" },
                { "data": "6" }
            ]
        });

    });

</script>