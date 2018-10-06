@include('frontend.layout.head')


@include('frontend.layout.loaders')
@include('frontend.layout.nav')

<style>
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-success, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-success {
        color: #fff;
        background: #e07fc1;
    }
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-default, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-default {
        color: #fff;
        background: #e07fc1;
    }
</style>

<!-- Inner Page Header
    ================================================== -->
<section class="tp--inner-header tp--section tp--section-dark tp--gradient-3 tp--pattern-1  text-center">

    <div class="container tp--vertical-align">

        {{-- <div class="row">

             <div class="col-xs-12">

                 <h2>Example Auth</h2>
                 <p>You answered "yes" or code is valid.</p>

             </div>

         </div>--}}

    </div>

</section>


<!-- Call to Action
================================================== -->
<section id="about" class="tp--section text-justify">

    <div class="page-header text-center">
        <h2>We needed libraries!</h2>
    </div>



</section>
<section id="testimonials" class="tp--section tp--testimonials tp--testimonials-2 text-center text-sm-left tp--padding-top-0">

    <div class="container">

        <div class="row">
            <div class="col-md-6">

                <div class="tp--floating-box tp--hover-1">

                    <div class="row tp--testimonial-header tp--col-sm-vertical-align">

                        <div class="col-sm-3">
                            <img class="img-circle img-responsive" src="{{asset('/frontend/images/ruby-vector-logo.png')}}">
                        </div>

                        <div class="col-sm-9 tp--padding-0">
                            <h4>Ruby library</h4>
                            <p>based on API</p>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <blockquote>
                                <p><a href="{{route('support.ticket.create')}}">try</a></p>
                            </blockquote>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6">

                <div class="tp--floating-box tp--hover-1">

                    <div class="row tp--testimonial-header tp--col-sm-vertical-align">

                        <div class="col-sm-3">
                            <img class="img-circle img-responsive" src="{{asset('/frontend/images/opengraph-icon-200x200.png')}}">
                        </div>

                        <div class="col-sm-9 tp--padding-0">
                            <h4>Python library</h4>
                            <p>based on API</p>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <blockquote>
                                <p><a href="{{route('support.ticket.create')}}">try</a></p>
                            </blockquote>

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <div class="tp--floating-box tp--hover-1">

                    <div class="row tp--testimonial-header tp--col-sm-vertical-align">

                        <div class="col-sm-3">
                            <img class="img-circle img-responsive" src="{{asset('/frontend/images/golang_icon.png')}}">
                        </div>

                        <div class="col-sm-9 tp--padding-0">
                            <h4>GO library</h4>
                            <p>based on API</p>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <blockquote>
                                <p><a href="{{route('support.ticket.create')}}">try</a></p>
                            </blockquote>

                        </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6">

                <div class="tp--floating-box tp--hover-1">

                    <div class="row tp--testimonial-header tp--col-sm-vertical-align">

                        <div class="col-sm-3">
                            <img class="img-circle img-responsive" src="{{asset('/frontend/images/user-avatar2.jpg')}}">
                        </div>

                        <div class="col-sm-9 tp--padding-0">
                            <h4>Other lang library</h4>
                            <p>based on API</p>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <blockquote>
                                <p><a href="{{route('support.ticket.create')}}">try</a></p>
                            </blockquote>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</section>

<section class="tp--section tp--cta tp--cta-2 tp--section-light">
    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-duration="750">

        <div class="row">

            <div class="col-sm-12 ">
                <p>Example structure of library. Client can set public and private key or in external config file:</p>
                <pre>PushAuthObject = new PushAuth('public_key', 'private_key);</pre>
                <p><br></p>
                <p>Client can make set fields:</p>
                <pre>
PushAuthObject -> mode('code')
               -> code('123-456')
               -> flash_response(false)
               -> send();
                </pre>
<p>Will return:</p>
                                <pre>
unique request hash code string(32)
                </pre>

                <p><br></p>
                <p>Client can request status by unique request hash:</p>
                <pre>
PushAuthObject -> showStatus('request_hash');
                </pre>
<p>Will return</p>
<pre>boolean</pre>

<h4><a href="{{route('frontend.content.api')}}">For more information view API</a> or our <a href="https://github.com/pushauth/pushauth-cpp">C++ lib</a></h4>
            </div>


        </div><!-- /.row -->
    </div>
    <div class="container">

{{--        <div class="row tp--col-sm-vertical-align">

            <div class="col-sm-7 col-sm-offset-1">
                <h2 class="title">Join</h2>
                <p>Sign up to PushAuth project and get more features.</p>
            </div>
            <div class="col-sm-3">
                <p><a href="#modal-register" class="btn btn-primary btn-lg popup-modal">Join now</a></p>
            </div>

        </div>--}}

    </div>

</section>

@include('frontend.layout.footer')
