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


<section id="about" class="tp--section text-justify">

    <div class="page-header text-center">
        <h2>FAQ</h2>
    </div>

    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-duration="750">

        <div class="row">

            <div class="col-md-3 text-right">
                <strong>
                    Is it FREE?
                </strong>

                </div>

            <div class="col-md-9">
                <p>Yes. The service is free, but have some limits. For view current limits, go to <a href="{{route('profile.price')}}">profile page.</a></p>
            </div>

        </div><!-- /.row -->


        <div class="row">

            <div class="col-md-3 text-right">
                <strong>
                    How to upgrade to PREMIUM without money?
                </strong>

            </div>

            <div class="col-md-9">
                <p>You can use PREMIUM plan maximum 6 month free if you developer and can help project. <a href="{{route('frontend.content.jobs')}}"> Details...</a></p>
            </div>

        </div><!-- /.row -->


        <div class="row">

            <div class="col-md-3 text-right">
                <strong>
                    Is it really secure?
                </strong>

            </div>

            <div class="col-md-9">
                <p>Yes. All data transfer via HTTPS/TLS and with HMAC SHA-256 signature.</p>
            </div>

        </div><!-- /.row -->


        <div class="row">

            <div class="col-md-3 text-right">
                <strong>
                    When i can use it?
                </strong>

            </div>

            <div class="col-md-9">
                <p>Web-sites authorization or anywhere with API.</p>
            </div>

        </div><!-- /.row -->

        <div class="row">

            <div class="col-md-3 text-right">
                <strong>
                    Is it really secure?
                </strong>

            </div>

            <div class="col-md-9">
                <p>Yes. All data transfer via HTTPS/TLS and with HMAC SHA-256 signature.</p>
            </div>

        </div><!-- /.row -->

    </div>

</section>

@include('frontend.layout.footer')
