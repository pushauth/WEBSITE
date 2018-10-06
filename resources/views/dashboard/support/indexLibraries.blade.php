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
            <h2 class="view-title">Libraries (for your Application)</h2>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
            <div class="col-wrapper col-md-9 col-sm-12 col-xs-12">

                @include('dashboard.support.libraries.php')

                @include('dashboard.support.libraries.java')



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
                                        <li><h4 > <a href="#php">PHP</a></h4>
                                           </li>
                                        <li><h4> <a href="#java">Java</a></h4>
                                           </li>
                                        <li><h4><a href="#cpp">C++</a></h4>
                                        </li>
                                        {{--<li><h4><a href="#exceptions">Exceptions</a></h4>
                                        </li>--}}
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

