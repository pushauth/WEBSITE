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
                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.profile.userinfo')
                            @include('dashboard.profile.nav')
                        </div>
                        <div class="content-panel">
                            <div class="content-header-wrapper">
                                <h2 class="title">{{$notify->subject}}</h2>

                            </div>




                                <p>
                                   {!! $notify->body !!}
                                </p>





                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

