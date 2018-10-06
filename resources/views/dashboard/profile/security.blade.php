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
                            <h2 class="title">Security</h2>




                            {!! Form::model($user,array('route' => 'profile.update.mail', 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}


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




                            {!! Form::model($user,array('route' => 'profile.update.password', 'autocomplete'=>'off', 'class'=>'form-horizontal')) !!}


                            <fieldset class="fieldset">
                                <h3 class="fieldset-title">Change Password</h3>


                                <div class="form-group @if ($errors->has('password_old')) has-error @endif">
                                    <label class="col-md-2 col-sm-3 col-xs-12 control-label" for="password_old">Old password *</label>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                        {!! Form::password('password_old', array('class'=>'form-control', 'placeholder'=>'Old password')) !!}
                                        @if ($errors->has('password_old')) <p class="help-block">{{ $errors->first('password_old') }}</p> @endif
                                    </div>
                                </div>

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

                           <br><br>
                            <h3 class="">SignIn logs (last 10)</h3><br>
                            <div class="table-responsive">
                                <table class="table table-condensed">

                                    <tbody>


                                    @foreach( $user->logins()->orderBy('id','desc')->take(10)->get() as $logins)

                                        <tr>

                                            <th scope="row"> {{$logins->ip}}</th>
                                            <td> {{$logins->user_agent}}</td>
                                            <td> {{$logins->created_at->format('l jS \\of F Y H:i:s ')  }} (UTC)</td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
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

