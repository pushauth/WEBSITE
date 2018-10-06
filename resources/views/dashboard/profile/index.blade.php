@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}



@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">My Account</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">


                @include('dashboard.layout.result_msg')


                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.profile.userinfo')

                            @include('dashboard.profile.nav')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Profile @if($user->role->role == 'admin')<span class="pro-label label label-purple">ADMIN</span> @elseif($user->role->role == 'user')<span class="pro-label label label-warning">USER</span>@endif</h2>


                                {!! Form::open(['route'=> 'profile.updateImage', 'method'=>'POST', 'files'=> true, 'class'=>'form-horizontal']) !!}

                                <fieldset class="fieldset">
                                    <h3 class="fieldset-title">Personal Info</h3>
                                    <div class="form-group avatar @if ($errors->has('user_img')) has-error @endif">
                                        <figure class="figure col-md-2 col-sm-3 col-xs-12">
                                            <img class="img-rounded img-responsive" src="{{$user->img}}" alt="" />
                                        </figure>
                                        <div class="form-inline col-md-10 col-sm-9 col-xs-12">

                                            {!! Form::file('user_img', ['class'=>'file-uploader pull-left']) !!}
                                            @if ($errors->has('user_img')) <p class="help-block">{{ $errors->first('user_img') }}</p> @endif

                                            <button type="submit" class="btn btn-sm btn-default-alt pull-left">Update Image</button>
                                        </div>
                                    </div>
                                    </fieldset>

                                    {!! Form::close() !!}


                                {!! Form::model($user,array('route' => 'profile.update', 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}



                                <fieldset class="fieldset">



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





                            <div class="module-content collapse in" id="content-1">
                                <div class="module-content-inner no-padding-bottom">
                                    <div class="panel-group" id="accordion-1" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne-1">
                                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-1" href="#collapseOne-1" aria-expanded="false" aria-controls="collapseOne-1"><i class="fa fa-trash"></i>Delete account</a></h4>
                                            </div>

                                            <div id="collapseOne-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne-1">
                                                <div class="panel-body">
                                                    <h4>Dangerous!</h4>
                                                    <p>All data will be removed and can not be restored from system.</p>
                                                    <p>Are you sure for this?</p>

                                                    <br>
                                                    {!! Form::open(['route'=> 'profile.delete', 'method'=>'POST', 'class'=>'form-horizontal']) !!}
                                                    <input class="btn btn-danger" type="submit" value="Delete account">
                                                    {!! Form::close() !!}

                                                </div>
                                            </div>
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



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

