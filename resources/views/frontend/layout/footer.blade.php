
<!-- Footer
================================================== -->
<footer id="footer" class="tp--footer tp--section-dark tp--gradient-3 tp--footer-1 text-xs-center">

    <div class="container">

        <div class="row">

            <div class="col-sm-3 col-md-3">

                <h3>Developing</h3>
                <ul class="list-unstyled">
                    <li><a href="{{route('frontend.content.api')}}">API documentation</a></li>
                    <li><a href="https://github.com/pushauth">Libraries</a></li>
                    <li><a href="{{route('frontend.content.faq')}}">FAQ</a></li>
                    <li><a href="{{route('login')}}">SingIn</a></li>
                </ul>

            </div>

            <div class="col-sm-3 col-md-3">

                <h3>Product</h3>
                <ul class="list-unstyled">
                    <li><a href="{{route('frontend.example')}}">How it works?</a></li>
                    <li><a href="{{route('support.ticket.create')}}">Support</a></li>

                    <li><a href="{{route('frontend.content.team')}}">Our team</a></li>

                </ul>

            </div>

            <div class="col-sm-3 col-md-3">

                <h3>Legal</h3>
                <ul class="list-unstyled">
                    <li><a href="{{route('frontend.content.terms')}}">Terms of Service</a></li>
                    <li><a href="{{route('frontend.content.policy')}}">Privacy Policy</a></li>

                </ul>

            </div>

            <div class="col-sm-3 col-md-3">

                <h3>Partnership</h3>
                <ul class="list-unstyled">
                    <li><a href="{{route('frontend.content.jobs')}}">Jobs&emsp;<span class="label label-primary" style="    background-color: transparent !important;
    border-style: solid;
    border-width: 1px;">We're hiring!</span></a></li>

                    <li><a href="mailto:info@pushauth.io">info@pushauth.io</a></li>
                </ul>


                <br>
                <p class="muted">© 2017 PushAuth.IO</p>

            </div>

        </div>

        <div class="row tp--social">
            <div class="col-lg-12 text-center">
                <a class="icon" href="http://www.twitter.com/dparrelli" target="_blank"><i class="fa fa-twitter"></i></a>
                <a class="icon" href="https://www.facebook.com/pushauth/" target="_blank"><i class="fa fa-facebook"></i></a>
                {{--<a class="icon" href="#" target="_blank"><i class="fa fa-slack"></i></a>--}}
                <a class="icon" href="https://github.com/pushauth" target="_blank"><i class="fa fa-github"></i></a>
                <a class="icon" href="https://www.youtube.com/channel/UCHHyGbihleHb5QnqUsUeayw" target="_blank"><i class="fa fa-youtube"></i></a>
            </div>
        </div>

    </div>

</footer>


@include('frontend.layout.endforms')



<!-- jQuery -->

{!! Html::script('frontend/js/jquery.min.js') !!}

<!-- Bootstrap Plugins -->
{!! Html::script('frontend/js/bootstrap.min.js') !!}

<!-- Template Plugins -->

{!! Html::script('frontend/js/plugins/classie/classie.js') !!}
{!! Html::script('frontend/js/plugins/owl-carousel/owl.carousel.min.js') !!}
{!! Html::script('frontend/js/plugins/isotope/isotope.pkgd.min.js') !!}
{!! Html::script('frontend/js/plugins/magnific-popup/jquery.magnific-popup.min.js') !!}
{!! Html::script('frontend/js/plugins/modernizr/modernizr-custom.js') !!}
{!! Html::script('frontend/js/plugins/aos/aos.js') !!}
{!! Html::script('frontend/js/plugins/jquery-validate/jquery.validate.min.js') !!}
{!! Html::script('frontend/js/plugins/loaders-css/loaders.css.js') !!}

<!-- Template Javascript -->
{!! Html::script('frontend/js/main.js') !!}
{{--{!! Html::script(elixir('assets/gulp/frontend-scripts.js')) !!}--}}

<script>



    var CSRF_TOKEN='{!! csrf_token() !!}';
    var SYS_URL='{!! URL::to('/'); !!}';


    $.ajaxSetup({
        // Disable caching of AJAX responses
        cache: false,
        headers: { 'X-CSRF-TOKEN' : CSRF_TOKEN }
    });



</script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-105769439-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>