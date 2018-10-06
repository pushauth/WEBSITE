@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}

{!!  Html::style('assets/css/pricing.css') !!}

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
                            <h2 class="title">Price Plan</h2>

                            @include('dashboard.layout.result_msg')


                            <div class="billing">
                                <div class="secure text-center margin-bottom-md">
                                    <h3 class="margin-bottom-md text-success">
                                        <span class="fs1 icon" aria-hidden="true" data-icon="&#xe06c;"></span>
                                        Secure credit card payment<br/>
                                        <small>This is a secure 256-bit TLS encrypted payment</small>
                                    </h3>

                                </div>








                                <div class="pricing-section">
                                    <h3 class="title text-center">Become a member and start growing your business!</h3>
                                    <p class="intro text-center margin-bottom-lg">Try PushAuth PREMIUM now!</p>
                                    <div class="plans row">
                                        <div class="item price-1 col-md-6 col-sm-6 col-xs-12 text-center">
                                            <div class="item-inner">
                                                <div class="heading">
                                                    <h3 class="item-title">{{$free['name']}}</h3>
                                                    <p class="price-figure"><span class="price-figure-inner"><span class="currency">$</span><span class="number">0</span>
														<br /><span class="unit">All time</span></span>
                                                    </p>
                                                </div>
                                                <div class="content">






                                                    <ul class="list-unstyled feature-list">
                                                        <li><span class="pe-icon pe-7s-box2 pe-2x pe-va"></span>{{$free['apps']}} Applications</li>
                                                        <li><span class="pe-icon pe-7s-chat pe-2x pe-va"></span>{{$free['pushes_month']}} Pushes per month
                                                        <br>
                                                            <small class="text-muted">* {{$free['pushes_day']}} Pushes per day</small>
                                                        </li>

                                                        <li><span class="pe-icon pe-7s-users pe-2x pe-va"></span>{{$free['users']}} Users</li>
                                                        <li><span class="pe-icon pe-7s-phone pe-2x pe-va"></span> {{$free['devices']}} Devices</li>

                                                        <li><span class="pe-icon pe-7s-date pe-2x pe-va"></span> Short logs last day</li>
                                                    </ul>
                                                    <ul class="list-unstyled feature-list-compare">
                                                        <li><i class="fa fa-check"></i> WebHooks</li>
                                                        <li><i class="fa fa-check"></i> SSL/Encrypt</li>
                                                        <li><i class="fa fa-check"></i> MultiPlarform libraries</li>
                                                        <li class="disabled"><i class="fa fa-close"></i> Push routes</li>

                                                        <li class=""><i class="fa fa-check"></i> 72 hours email support</li>
                                                    </ul>


                                                    @if ($user->plan->plan->name == 'FREE')
                                                    <button type="button" class="btn btn-primary btn-block disabled"> <i class="fa fa-check"></i>Selected</button>
                                                        @else
                                                        <a href="{{route('profile.price.update', $free['name'])}}" class="btn btn-primary btn-block"> <i class="fa fa-check"></i>Select</a>
                                                    @endif
                                                </div>

                                            </div>

                                        </div>

                                        <div class="item item-recommended price-1 col-md-6 col-sm-6 col-xs-12 text-center">
                                            <div class="item-inner">
                                                <div class="heading">
                                                    <h3 class="item-title">{{$premium['name']}}</h3>

                                                    <p class="price-figure"><span class="price-figure-inner"><span class="currency">$</span><span class="number">49</span>
														<br /><span class="unit">Per Month</span></span>
                                                    </p>
                                                </div>




                                                <div class="content">
                                                <ul class="list-unstyled feature-list">
                                                    <li><span class="pe-icon pe-7s-box2 pe-2x pe-va"></span>{{$premium['apps']}} Applications</li>
                                                    <li><span class="pe-icon pe-7s-chat pe-2x pe-va"></span>{{$premium['pushes_month']}} Pushes per month
                                                        <br>
                                                        <small class="text-muted">* {{$premium['pushes_day']}} Pushes per day</small>
                                                    </li>

                                                    <li><span class="pe-icon pe-7s-users pe-2x pe-va"></span>{{$premium['users']}} Users</li>
                                                    <li><span class="pe-icon pe-7s-phone pe-2x pe-va"></span> {{$premium['devices']}} Devices</li>

                                                    <li><span class="pe-icon pe-7s-date pe-2x pe-va"></span> Full logs 1 month</li>
                                                </ul>
                                                <ul class="list-unstyled feature-list-compare">
                                                    <li><i class="fa fa-check"></i> WebHooks</li>
                                                    <li><i class="fa fa-check"></i> SSL/Encrypt</li>
                                                    <li><i class="fa fa-check"></i> MultiPlarform libraries</li>
                                                    <li class=""><i class="fa fa-check"></i> Push routes</li>

                                                    <li class=""><i class="fa fa-check"></i> 24 hours email/slack support</li>
                                                </ul>
                                                    @if ($user->plan->plan->name == 'PREMIUM')
                                                        <button type="button" class="btn btn-primary btn-block disabled"> <i class="fa fa-check"></i>Selected</button>
                                                    @else
                                                        <a href="{{route('profile.price.update', $premium['name'])}}" class="btn btn-primary btn-block"> <i class="fa fa-check"></i>Select</a>
                                                    @endif
                                                    </div>

                                            </div>

                                        </div>



                                    </div>

                                </div>






                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

