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
<section class="tp--section tp--cta tp--cta-2 tp--section-light">
    <div class="page-header text-center">
        <i class=" fa fa-check-circle-o"></i>
        <h2>Success!</h2>
    </div>
    <div class="container">

        <div class="row tp--col-sm-vertical-align">


            <div class="col-md-6 col-md-offset-3">



                <div class="alert alert-success alert-theme-solid alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Well done!</strong> You successfully logged in!
                </div>
                <p class="text-center">
                    <a href="{{route('frontend.example')}}">
                    <span type="button" class="btn btn-lg btn-pink"><i class="fa fa-mail-reply"></i>  Back</span>
                    </a>
                </p>




            </div>

        </div>

    </div>

</section>

@include('frontend.layout.footer')
