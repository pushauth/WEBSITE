
<!-- Login Form -->

<div id="modal-login" class="tp--authentication text-center white-popup mfp-hide">

    <section class="tp--authentication-container">

        <div class="page-header">
            <h3>Login to your account</h3>
        </div>

        <div class="row">

            <div class="col-sm-12">



                    {!! Form::open(array('route' => 'loginPost','id'=>'form_login', 'class'=>'form-authentication', 'autocomplete'=>'off')) !!}



                    <div class="form-group">
                        <i class="icon-envelope"></i>

                        {!! Form::text('email', '', array('class'=>'form-control', 'type'=>'email', 'id'=>'login-email',
                                'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Enter your email')) !!}
                    </div>

                    <div class="form-group">
                        <i class="icon-lock"></i>

                        {!! Form::password('password', array('class'=>'form-control', 'type'=>'password', 'id'=>'login-password',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Password')) !!}
                    </div>

                    <input class="button" name="commit" type="submit" value="Login">

                    <div class="tp--authentication-footer">
                        <p class="links clearfix">
                            <a class="pull-left" href="{{route('register')}}">Don't have an account? Sign up</a>
                            <a class="pull-right" href="{{route('forgotPassword')}}">Forgot your password?</a>
                        </p>
                    </div>

                {!! Form::close() !!}

            </div>

        </div>

    </section>

</div>


<!-- Registration Form -->

<div id="modal-register" class="tp--authentication text-center white-popup mfp-hide">

    <section class="tp--authentication-container">

        <div class="page-header">
            <h3>Register a new account</h3>
        </div>

        <div class="row">

            <div class="col-sm-12">




                    {!! Form::open(array('route' => 'registerPost', 'class'=>'form-authentication', 'autocomplete'=>'off')) !!}


                    <div class="form-group">
                        <i class="icon-envelope"></i>

                        {!! Form::text('email', '', array('class'=>'form-control', 'type'=>'email', 'id'=>'login-email',
                                'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Enter your email')) !!}

                    </div>

                    <div class="form-group">
                        <i class="icon-lock"></i>


                        {!! Form::password('password', array('class'=>'form-control', 'type'=>'password', 'id'=>'login-password',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Enter your password')) !!}


                    </div>

                    <div class="form-group">
                        <i class="icon-lock"></i>


                        {!! Form::password('password_confirmation', array('class'=>'form-control', 'type'=>'password', 'id'=>'login-password',
                                'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'Re-enter your password')) !!}



                    </div>

                    <input class="button" name="commit" type="submit" value="Register your account">

                    <div class="tp--authentication-footer">
                        <p class="disclaimer">By registering an account, you agree with our <a href="{{route('frontend.content.terms')}}">Terms of Service</a> and <a href="{{route('page.privacy')}}">Privacy Policy</a>.</p>
                        <p class="links">
                            <a class="" href="{{route('login')}}">Already have an account? Login</a>
                        </p>
                    </div>

               {!! Form::close() !!}

            </div>

        </div>

    </section>

</div>


<!-- Contact Form -->

<div id="modal-contact" class="tp--contact text-center white-popup mfp-hide">

    <div class="page-header">
        <h3>Get in touch</h3>
        <p>Feel free to get in touch with us by sending your message below.</p>
    </div>


    <form id="contact-form" method="post" action="contact-form/contact.php" role="form">

        <div class="messages"></div>

        <div class="controls">

            <div class="row">
                <div class="col-md-12">

                    <label for="form_name">Full Name *</label>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="form_lastname" class="sr-only">First Name *</label>
                                <input id="form_name" type="text" name="name" class="form-control" placeholder="First name" required="required">
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="form_lastname" class="sr-only">Last Name *</label>
                                <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Last name" required="required">
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="form_email">Email *</label>
                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email" required="required">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="form_message">Message *</label>
                        <textarea id="form_message" name="message" class="form-control" placeholder="Please enter your message" rows="4" required="required"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <input type="submit" class="btn btn-primary btn-lg btn-circular btn-send" value="Send your message">
                </div>
            </div>

        </div>

    </form>

</div>
