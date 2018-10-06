@include('frontend.layout.head')


@include('frontend.layout.loaders')
@include('frontend.layout.nav')

<style>
    .tp--section .page-header i {
        background: #f55b48 !important;
        background: -webkit-linear-gradient(top, #f77b6b, #f55b48) !important;
        background: linear-gradient(to bottom, #f77b6b, #f55b48) !important;
        color: white;
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
        <i class=" fa fa-close"></i>
        <h2>Access denied!</h2>
    </div>
    <div class="container">

        <div class="row tp--col-sm-vertical-align">


            <div class="col-md-6 col-md-offset-3">



                <div class="alert alert-danger alert-theme-solid alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong>Ooops!</strong> You can not Sign In! :(
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
