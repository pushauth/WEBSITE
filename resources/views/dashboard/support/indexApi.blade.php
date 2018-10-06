@include('dashboard.layout.header')

{!!  Html::style('assets/js/highlight/styles/tomorrow.css') !!}



@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<style>

</style>







<div id="content-wrapper" class="content-wrapper view project-single-view" >
    <div class="container-fluid">
        <div class="project-heading">
            <h2 class="view-title">API (server side application)</h2>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
            <div class="col-wrapper col-md-9 col-sm-12 col-xs-12">

                @include('dashboard.support.api_app.encoding')

                @include('dashboard.support.api_app.req')

                @include('dashboard.support.api_app.response')
                @include('dashboard.support.api_app.decoding')

                @include('dashboard.support.api_app.qrcode')
                @include('dashboard.support.api_app.qrcode_res')

                @include('dashboard.support.api_app.check_req')

                @include('dashboard.support.api_app.check_res')

                @include('dashboard.support.api_app.security')

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
                </div>
                {{--<div class="module-wrapper" >
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
                </div>--}}
            </div>
        </div>
    </div>
</div>







@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
{!! Html::script('assets/js/highlight/highlight.pack.js') !!}



<script>
    $(document).ready(function() {
        'use strict';

        hljs.initHighlightingOnLoad();
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
        } );


/*        $body.scrollspy({
            target: '#leftCol',
            offset: navHeight
        });*/
    });

</script>

