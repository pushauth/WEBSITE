@include('frontend.layout.head')


@include('frontend.layout.loaders')
@include('frontend.layout.nav')
{!!  Html::style('assets/js/highlight/styles/zenburn.css') !!}
<style>

    .group {
        background: yellow;
        width: 200px;
        height: 500px;
    }
    .group .subgroup {
        background: orange;
        width: 150px;
        height: 200px;
    }
    .fixed {
        position: fixed;
    }

    /* sidebar */
    .bs-docs-sidebar {
        padding-left: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* all links */
    .bs-docs-sidebar .nav>li>a {
        color: #999;
        border-left: 2px solid transparent;
        padding: 4px 20px;
        font-size: 13px;
        font-weight: 400;
    }

    /* nested links */
    .bs-docs-sidebar .nav .nav>li>a {
        padding-top: 1px;
        padding-bottom: 1px;
        padding-left: 30px;
        font-size: 12px;
    }

    /* active & hover links */
    .bs-docs-sidebar .nav>.active>a,
    .bs-docs-sidebar .nav>li>a:hover,
    .bs-docs-sidebar .nav>li>a:focus {
        color: #563d7c;
        text-decoration: none;
        background-color: transparent;
        border-left-color: #563d7c;
    }
    /* all active links */
    .bs-docs-sidebar .nav>.active>a,
    .bs-docs-sidebar .nav>.active:hover>a,
    .bs-docs-sidebar .nav>.active:focus>a {
        font-weight: 700;
    }
    /* nested active links */
    .bs-docs-sidebar .nav .nav>.active>a,
    .bs-docs-sidebar .nav .nav>.active:hover>a,
    .bs-docs-sidebar .nav .nav>.active:focus>a {
        font-weight: 500;
    }

    /* hide inactive nested list */
    .bs-docs-sidebar .nav ul.nav {
        display: none;
    }
    /* show active nested list */
    .bs-docs-sidebar .nav>.active>ul.nav {
        display: block;
    }

    /*Header formatting */
    .MainContent {
        margin-top: 50px;
    }
    .group, .subgroup {
        padding-top: 50px;
        margin-top: -50px;
    }

</style>

<!-- Inner Page Header
    ================================================== -->
<section class="tp--inner-header tp--section tp--section-dark tp--gradient-3 tp--pattern-1  text-center">

    <div class="container tp--vertical-align">



    </div>

</section>

<section id="about" class="tp--section text-justify">













    </section>


{{--
<section id="about" class="tp--section text-justify">

    <div class="page-header text-center">
        <h2>API</h2>
    </div>








    <div class="container --}}{{--aos-init aos-animate--}}{{--" --}}{{--data-aos="fade-up" data-aos-duration="750"--}}{{-->


        <!-- Main Content -->



       --}}{{-- <div class="row" >
            <div class="col-wrapper col-md-9 col-sm-12 col-xs-12" style="font-size: 14px;">

                @include('dashboard.support.api_app.encoding')
<hr>
                @include('dashboard.support.api_app.req')
                <hr>
                @include('dashboard.support.api_app.response')
                <hr>
                @include('dashboard.support.api_app.decoding')
                <hr>
                @include('dashboard.support.api_app.qrcode')
                <hr>
                @include('dashboard.support.api_app.qrcode_res')
                <hr>

                @include('dashboard.support.api_app.check_req')
                <hr>

                @include('dashboard.support.api_app.check_res')
                <hr>

                @include('dashboard.support.api_app.security')
                <hr>

                @include('dashboard.support.api_app.exceptions')





            </div>
            <div class="col-wrapper col-md-3 col-sm-12 col-xs-12 " >
                <div class="module-wrapper " id="navs" data-spy="" data-offset-top="0" style="top: 10px;">
                    <section class="module commits-module " >
                        <div class="module-inner" >
                            <div class="module-heading">
                                <h3 class="module-title">Navigation</h3>
                            </div>

                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    <ul class="list">
                                        <li><h4>Authorization Request</h4>
                                            <ul>
                                                <li><h5><a href="#encoding">Encoding Request</a></h5></li>
                                                <li><h5><a href="#req">Send Request</a></h5></li>
                                                <li><h5><a href="#response">Receive Response</a></h5></li>
                                                <li><h5><a href="#decoding">Decode Response</a></h5></li>
                                            </ul></li>
                                        <li><h4>Auth by QR-code</h4>
                                            <ul>
                                                <li><h5><a href="#qr_req">Request</a></h5></li>
                                                <li><h5><a href="#qr_res">Response</a></h5></li>
                                            </ul>
                                        </li>
                                        <li><h4>Check request status</h4>
                                            <ul>
                                                <li><h5><a href="#check_req">Request</a></h5></li>
                                                <li><h5><a href="#check_res">Response</a></h5></li>
                                            </ul></li>
                                        <li><h4><a href="#security">Security</a></h4>
                                        </li>
                                        <li><h4><a href="#exceptions">Exceptions</a></h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>--}}{{--
                --}}{{--<div class="module-wrapper" >
                    <section class="module related-module">
                        <div class="module-inner">
                            <div class="module-heading">
                                <h3 class="module-title">Libraries</h3>
                            </div>

                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    <ul class="list-unstyled">
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">PHP</a></li>
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">Java</a></li>
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">C++</a></li>
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">Perl</a></li>
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">Ruby</a></li>
                                        <li><span aria-hidden="true" class="fa fa-cube"></span>  <a href="#">Python</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>--}}{{--
           --}}{{-- </div>
        </div>--}}{{--
    </div>

</section>--}}

@include('frontend.layout.footer')
{!! Html::script('assets/js/highlight/highlight.pack.js') !!}



<script>
    $(document).ready(function() {
        'use strict';

       /* $('body').scrollspy({
            target: '.bs-docs-sidebar',
            offset: 0
        });*/

       /* hljs.initHighlightingOnLoad();
        var $body   = $(document.body);
        var navHeight = $('#navs').outerHeight(true) + 10;

        $('#navs').affix({
            offset: {
                top: 0,
                bottom: navHeight
            }
        });

        $( '#navs' ).on( 'affix.bs.affix', function(){
            if( !$( window ).scrollTop() ) return false;
        } );*/

        $('pre code').each(function (i, block) {
            hljs.highlightBlock(block);
        });
        /*        $body.scrollspy({
         target: '#leftCol',
         offset: navHeight
         });*/
    });

</script>
