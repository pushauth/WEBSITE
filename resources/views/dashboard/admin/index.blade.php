@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')



<div id="content-wrapper" class="content-wrapper view tickets-view projects-view">
    <div class="container-fluid">
        <div class="projects-heading">
            <h2 class="view-title">Dashboard</h2>

        </div>
        <div class="clearfix"></div>
        <div class="row">





            <div class="module-wrapper col-md-12 col-sm-12 col-xs-12">






                <section class="module tickets-module">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="title">Total information</h3>
                        </div>
                        <div class="module-content">
                            <div class="module-content-inner no-padding-bottom">
                                <div class="summary-container margin-bottom-md">
                                    <h4>User information</h4>
                                    <div class="row">
                                        <div class="item item-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Total Users</h4>
                                            <p class="item-figure text-success">{{$totalUsers->where('status','enable')->where('confirmed','true')->count()}}</p>

                                        </div>

                                        <div class="item item-closed-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Server users</h4>
                                            <p class="item-figure text-danger">{{$totalUsers->where('status','enable')->where('confirmed','true')->count()}}</p>
                                        </div>

                                        <div class="item item-commits col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Mobile users only</h4>
                                            <p class="item-figure text-info">{{$totalUsers->where('status','enable')->where('confirmed','false')->count()}}</p>
                                        </div>

                                        <div class="item item-comments  col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Confirmation</h4>
                                            <p class="item-figure text-purple">{{$totalUsers->where('status','enable')->where('confirmed','false')->count()}}</p>
                                            <small style="font-size: 10px;" class="item-title">users / devices </small>
                                        </div>



                                    </div>

                                </div>

                                <div class="summary-container margin-bottom-md">
                                    <h4>Confirmations</h4>
                                    <div class="row">
                                        <div class="item item-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Users success</h4>
                                            <p class="item-figure text-success">{{$totalUserConfirmed->where('status','true')->count()}}</p>

                                        </div>

                                        <div class="item item-closed-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Users fail</h4>
                                            <p class="item-figure text-danger">{{$totalUserConfirmed->where('status','false')->count()}}</p>
                                        </div>

                                        <div class="item item-commits col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Devices success</h4>
                                            <p class="item-figure text-info">{{$totalDeviceConfirmed->where('status','true')->count()}}</p>
                                        </div>

                                        <div class="item item-comments  col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Devices fail</h4>
                                            <p class="item-figure text-purple">{{$totalDeviceConfirmed->where('status','false')->count()}}</p>
                                            <small style="font-size: 10px;" class="item-title">users / devices </small>
                                        </div>



                                    </div>

                                </div>


                                <div class="summary-container margin-bottom-md">
                                    <h4>Pushes</h4>
                                    <div class="row">
                                        <div class="item item-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Code</h4>
                                            <p class="item-figure text-success">{{$totalPushes->where('mode','code')->count()}}</p>

                                        </div>

                                        <div class="item item-closed-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Push</h4>
                                            <p class="item-figure text-danger">{{$totalPushes->where('mode','push')->count()}}</p>
                                        </div>

                                        <div class="item item-commits col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">QR</h4>
                                            <p class="item-figure text-info">{{$totalPushes->where('mode','qr')->where('response_code',200)->count()}}</p>
                                        </div>

                                        <div class="item item-comments  col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Routes</h4>
                                            <p class="item-figure text-purple">{{$totalPushes->where('mode','route')->count()}}</p>

                                        </div>



                                    </div>

                                </div>

                                <div class="summary-container margin-bottom-md">
                                    <h4>Devices</h4>
                                    <div class="row">
                                        <div class="item item-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">iOS</h4>
                                            <p class="item-figure text-success">{{$totalDevices->where('os','ios')->count()}}</p>

                                        </div>

                                        <div class="item item-closed-tickets col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Android</h4>
                                            <p class="item-figure text-danger">{{$totalDevices->where('os','android')->count()}}</p>
                                        </div>

                                        <div class="item item-commits col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Enabled</h4>
                                            <p class="item-figure text-info">{{$totalDevices->where('status','enable')->count()}}</p>
                                        </div>

                                        <div class="item item-comments  col-md-3 col-sm-6 col-xs-6">
                                            <h4 class="item-title">Disabled</h4>
                                            <p class="item-figure text-purple">{{$totalDevices->where('status','disable')->count()}}</p>

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




