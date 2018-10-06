@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/member.css') !!}
{!!  Html::style('assets/css/project.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')




<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">{{$client->name}}</h2>


        <div id="masonry" class="row">
            <div class="col-wrapper col-md-3 ">
                <div class="module-wrapper">
                    <section class="module member-module module-no-heading module-no-footer">
                        <div class="module-inner">
                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    <div class="profile">
                                        <img class="img-responsive" src="@if ($client->profile->user_img == Null) {{route('profile.showImage', 'default_avatar.png') }} @else {{route('profile.showImage', $client->profile->user_img) }} @endif" alt="">
                                    </div>



<hr>

                                   {{-- <ul class="meta-data list-unstyled">
                                        <li><span aria-hidden="true" class="icon icon icon_id"></span> Full-stack Developer</li>
                                        <li><span aria-hidden="true" class="icon icon_pin_alt"></span> San Francisco, CA</li>
                                        <li><span aria-hidden="true" class="icon icon_mail_alt"></span> david.t@website.com</li>
                                        <li><span aria-hidden="true" class="icon icon_clock_alt"></span> 18 July 2015</li>
                                    </ul>--}}
                                    <div class="contact">
                                        <a href="{{route('admin.notify',$client->id)}}" class="btn btn-success"><i class="fa fa-paper-plane"></i> Send a message</a>
                                        <br><br>
                                        <a href="{{route('admin.login.user',$client->id)}}" class="btn btn-primary"><i class="fa fa-sign-in"></i> Login As user</a>
<hr>
                                        <a href="{{route('admin.delete.user',$client->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
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

                                    <li role="presentation"><a href="#profile-7" aria-controls="profile-7" role="tab" data-toggle="tab"><span class="fa fa-cubes" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Apps</span></a></li>

                                    <li role="presentation"><a href="#messages-7" aria-controls="messages-7" role="tab" data-toggle="tab"><span class="fa fa-mobile" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Devices</span></a></li>

                                    <li class="last" role="presentation"><a href="#settings-7" aria-controls="settings-7" role="tab" data-toggle="tab"><span class="fa fa-cog" aria-hidden="true" ></span><br><span class="hidden-xs hidden-sm">Settings</span></a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home-7">
                                        <div class="meta-data">
                                            <dl class="dl-horizontal">
                                                <dt>Confirmed:</dt>
                                                <dd>@if($client->confirmed == 'true')<span class="label label-success">true</span>
                                                @else <span class="label label-danger">false</span>

                                                    @endif</dd>
                                                <dt>Enable:</dt>
                                                <dd>@if($client->status == 'enable')<span class="label label-success">true</span>

                                                    @else <span class="label label-danger">false</span>

                                                    @endif</dd>




                                                <dt>Email:</dt>
                                                <dd>{{$client->email}}</dd>
                                                <dt>Last login:</dt>
                                                <dd>
                                                    @if ($client->logins->count() == 0)
                                                        -
                                                        @else
                                                    {{$client->logins()->orderBy('id','desc')->first()->created_at->format('l jS \\of F Y H:i:s ')}}
                                                @endif
                                                </dd>

                                                <dt>Register:</dt>
                                                <dd>{{$client->created_at->format('l jS \\of F Y H:i:s ')}}</dd>
                                            </dl>
                                            <hr>
                                            <dl class="dl-horizontal">
                                                <dt>Name:</dt>
                                                <dd>{{$client->name}}</dd>
                                                <dt>Full name:</dt>
                                                <dd>{{$client->profile->first_name}} {{$client->profile->last_name}}</dd>
                                                <dt>Website:</dt>
                                                <dd>{{$client->profile->website}} </dd>
                                                <dt>Tel:</dt>
                                                <dd>{{$client->profile->tel}}</dd>
                                                <dt>Company:</dt>
                                                <dd>{{$client->profile->company}}</dd>
                                            </dl>
                                            <hr>


<h4>Logins</h4>
                                            <div class="table-responsive">
                                                <table id="datatables-1" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>IP</th>
                                                        <th>User-Agent</th>

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

                                    <div role="tabpanel" class="tab-pane" id="profile-7">
                                        <div class="meta-data">
                                        <div class="table-responsive">
                                            <table id="datatables-2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Pushes</th>
                                                    <th>Devices</th>
                                                    <th>User</th>
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






                                        {!! Form::open(['route'=> ['admin.update.user.image',$client->id], 'method'=>'POST', 'files'=> true, 'class'=>'form-horizontal']) !!}

                                        <fieldset class="fieldset">
                                            <h3 class="fieldset-title">Personal Info</h3>
                                            <div class="form-group avatar @if ($errors->has('user_img')) has-error @endif">
                                                <figure class="figure col-md-2 col-sm-3 col-xs-12">
                                                    <img class="img-rounded img-responsive" src="@if ($client->profile->user_img == Null) {{route('profile.showImage', 'default_avatar.png') }} @else {{route('profile.showImage', $client->profile->user_img) }} @endif" alt="" />
                                                </figure>
                                                <div class="form-inline col-md-10 col-sm-9 col-xs-12">

                                                    {!! Form::file('user_img', ['class'=>'file-uploader pull-left']) !!}
                                                    @if ($errors->has('user_img')) <p class="help-block">{{ $errors->first('user_img') }}</p> @endif

                                                    <button type="submit" class="btn btn-sm btn-default-alt pull-left">Update Image</button>
                                                    <a href="{{route('admin.delete.user.image',$client->id)}}" class="btn btn-danger-alt btn-xs">delete</a>
                                                </div>
                                            </div>
                                        </fieldset>

                                        {!! Form::close() !!}


                                        {!! Form::model($client,array('route' => ['admin.update.user.profile',$client->id], 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}



                                        <fieldset class="fieldset">

                                            <div class="form-group @if ($errors->has('confirmed')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="confirmed">Confirmed *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::select('confirmed',['true'=>'true','false'=>'false'] ,$client->confirmed, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('confirmed')) <p class="help-block">{{ $errors->first('confirmed') }}</p> @endif
                                                </div>
                                            </div>



                                            <div class="form-group @if ($errors->has('status')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="status">Status *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::select('status',['enable'=>'enable','disable'=>'disable'] ,$client->status, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
                                                </div>
                                            </div>



                                            <div class="form-group @if ($errors->has('role')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="role">Role *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::select('role',['admin'=>'admin','user'=>'user'] ,$client->role->role, array('class'=>'form-control')) !!}
                                                    @if ($errors->has('role')) <p class="help-block">{{ $errors->first('role') }}</p> @endif
                                                </div>
                                            </div>


                                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="name">User Name *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Your nickname')) !!}
                                                    @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                                </div>
                                            </div>


                                            <div class="form-group @if ($errors->has('profile.first_name')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="profile[first_name]">First Name</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('profile[first_name]', null, array('class'=>'form-control', 'placeholder'=>'Your first name')) !!}
                                                    @if ($errors->has('profile.first_name')) <p class="help-block">{{ $errors->first('profile.first_name') }}</p> @endif
                                                </div>
                                            </div>


                                            <div class="form-group @if ($errors->has('profile.last_name')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="profile[last_name]">Last Name</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('profile[last_name]', null, array('class'=>'form-control', 'placeholder'=>'Your last name')) !!}
                                                    @if ($errors->has('profile.last_name')) <p class="help-block">{{ $errors->first('profile.last_name') }}</p> @endif
                                                </div>
                                            </div>



                                            <hr>

                                            <div class="form-group @if ($errors->has('profile.company')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="profile[company]">Company name</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('profile[company]', null, array('class'=>'form-control', 'placeholder'=>'Your Company name')) !!}
                                                    @if ($errors->has('profile.company')) <p class="help-block">{{ $errors->first('profile.company') }}</p> @endif
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('profile.website')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="profile[website]">Website</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('profile[website]', null, array('class'=>'form-control', 'placeholder'=>'Your website URL')) !!}
                                                    @if ($errors->has('profile.website')) <p class="help-block">{{ $errors->first('profile.website') }}</p> @endif
                                                </div>
                                            </div>


                                            <div class="form-group @if ($errors->has('profile.tel')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="profile[tel]">Tel</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('profile[tel]', null, array('class'=>'form-control', 'placeholder'=>'Your telephone number')) !!}
                                                    @if ($errors->has('profile.tel')) <p class="help-block">{{ $errors->first('profile.tel') }}</p> @endif
                                                </div>
                                            </div>




                                        </fieldset>
                                        <div class="form-group">
                                            <div class="col-md-10 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                                <input class="btn btn-primary" type="submit" value="Update Profile">
                                            </div>
                                        </div>
                                        {!! Form::close() !!}


<hr>
                                        <h4>Security</h4>








                                        {!! Form::model($client,array('route' => ['admin.update.user.email',$client->id], 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}


                                        <fieldset class="fieldset">
                                            <h3 class="fieldset-title">Change Login/Email</h3>
                                            <div class="form-group @if ($errors->has('email')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="email">Email *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Your email number')) !!}
                                                    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                                </div>
                                            </div>


                                        </fieldset>


                                        <div class="form-group">
                                            <div class="col-md-10 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                                <input class="btn btn-primary" type="submit" value="Update Email">
                                            </div>
                                        </div>

                                        {!! Form::close() !!}


                                        <hr>



                                        {!! Form::model($client,array('route' => ['admin.update.user.password',$client->id], 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}


                                        <fieldset class="fieldset">
                                            <h3 class="fieldset-title">Change Password</h3>




                                            <div class="form-group @if ($errors->has('password')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="password">New *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::password('password', array('class'=>'form-control', 'placeholder'=>'New password')) !!}
                                                    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                                </div>
                                            </div>

                                            <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                                                <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="password_confirmation">Confirm new *</label>
                                                <div class="col-md-10 col-sm-9 col-xs-12">
                                                    {!! Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm password')) !!}
                                                    @if ($errors->has('password_confirmation')) <p class="help-block">{{ $errors->first('password_confirmation') }}</p> @endif
                                                </div>
                                            </div>


                                        </fieldset>


                                        <div class="form-group">
                                            <div class="col-md-10 col-sm-9 col-xs-12 col-md-push-2 col-sm-push-3 col-xs-push-0">
                                                <input class="btn btn-primary" type="submit" value="Update Password">
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





<script>
    $(document).ready(function() {
        'use strict';


        $('#datatables-1').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            //"searchDelay": 500,
            "order": [[ 1, "desc" ]],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "ajax": {
                "url": "{{route('admin.ajax.logins', $client->id)}}",
                "type": "POST"
            },
            "columns": [
                { "data": "1" },
                { "data": "2" },
                { "data": "3" }
            ]
        });


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
                "url": "{{route('admin.ajax.apps',$client->id)}}",
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
                "url": "{{route('admin.ajax.devices',$client->id)}}",
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