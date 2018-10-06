@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')







{{--<div id="content-wrapper" class="content-wrapper view widgets-view">
    <div class="container-fluid">
        <h2 class="view-title">Widgets</h2>
        <div class="row">
            d
        </div>


    </div>
</div>--}}

<div id="content-wrapper" class="content-wrapper view tickets-view projects-view">
<div class="container-fluid">
    <div class="projects-heading">
        <h2 class="view-title">Dashboard</h2>

    </div>
    <div class="clearfix"></div>
    <div class="row">





{{--

        <div class="module-wrapper">

            <section class="module module-applications">
                <div class="module-inner">
                    <div class="module-heading">
                        <h3 class="module-title">Applications</h3>
                        <ul class="actions list-inline">
                            <li><a class="collapse-module" data-toggle="collapse" href="#content-8" aria-expanded="false" aria-controls="content-8"><span aria-hidden="true" class="icon arrow_carrot-up"></span></a></li>
                            <li><a class="close-module" href="#"><span aria-hidden="true" class="icon icon_close"></span></a></li>
                        </ul>
                    </div>
                    <div class="module-content collapse in" id="content-8">
                        <div class="module-content-inner no-padding-bottom">
                            <div class="utility">
                            </div>
                            <div class="items-wrapper">
                                <div class="item">
                                    <div class="name">
                                        <div class="data"><a href="#">Ace</a></div>
                                        <div class="note"><a href="#">aceapp.com</a></div>
                                    </div>
                                    <div class="stats text-center">
                                        <div class="status">
                                            <div class="data text-success">Up</div>
                                            <div class="note">Current Status</div>
                                        </div>
                                        <div class="uptime">
                                            <div class="data text-pink">100%</div>
                                            <div class="note">365 day uptime</div>
                                        </div>
                                        <div class="load-time">
                                            <div class="data text-info">4.5</div>
                                            <div class="note">Avg. loading time</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="name">
                                        <div class="data"><a href="#">Curabitur</a></div>
                                        <div class="note"><a href="#">curabitur.com</a></div>
                                    </div>
                                    <div class="stats text-center">
                                        <div class="status">
                                            <div class="data text-success">Up</div>
                                            <div class="note">Current Status</div>
                                        </div>
                                        <div class="uptime">
                                            <div class="data text-pink">98%</div>
                                            <div class="note">365 day uptime</div>
                                        </div>
                                        <div class="load-time">
                                            <div class="data text-info">6.3</div>
                                            <div class="note">Avg. loading time</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="name">
                                        <div class="data"><a href="#">Maecenas</a></div>
                                        <div class="note"><a href="#">maecenastempus.com</a></div>
                                    </div>
                                    <div class="stats text-center">
                                        <div class="status">
                                            <div class="data text-danger">Down</div>
                                            <div class="note">Current Status</div>
                                        </div>
                                        <div class="uptime">
                                            <div class="data text-pink">86%</div>
                                            <div class="note">365 day uptime</div>
                                        </div>
                                        <div class="load-time">
                                            <div class="data text-info">8.2</div>
                                            <div class="note">Avg. loading time</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="name">
                                        <div class="data"><a href="#">Quisque</a></div>
                                        <div class="note"><a href="#">quisque.com</a></div>
                                    </div>
                                    <div class="stats text-center">
                                        <div class="status">
                                            <div class="data text-success">Up</div>
                                            <div class="note">Current Status</div>
                                        </div>
                                        <div class="uptime">
                                            <div class="data text-pink">99%</div>
                                            <div class="note">365 day uptime</div>
                                        </div>
                                        <div class="load-time">
                                            <div class="data text-info">1.8</div>
                                            <div class="note">Avg. loading time</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
--}}



        <div class="module-wrapper col-md-12 col-sm-12 col-xs-12">






            <section class="module tickets-module">
                <div class="module-inner">
                    <div class="module-heading">
                        <h3 class="title">Your Pushes information</h3>
                    </div>
                    <div class="module-content">
                        <div class="module-content-inner no-padding-bottom">
                            <div class="summary-container margin-bottom-md">
                                <div class="row">
                                    <div class="item item-tickets col-md-3 col-sm-6 col-xs-6">
                                        <h4 class="item-title">Total Apps</h4>
                                        <p class="item-figure text-success">{{$user->app()->count()}} / {{$user->plan->limits->where('key', 'apps')->first()->value}}</p>
                                    </div>

                                    <div class="item item-closed-tickets col-md-3 col-sm-6 col-xs-6">
                                        <h4 class="item-title">Total Pushes </h4>
                                        <p style="margin-bottom: 0px;" class="item-figure text-danger">{{$pushesCount}} / {{$user->plan->limits->where('key', 'pushes')->where('period', 'month')->first()->value}}</p>
                                        <small style="font-size: 10px;" class="item-title">* per month</small>
                                    </div>

                                    <div class="item item-commits col-md-3 col-sm-6 col-xs-6">
                                        <h4 class="item-title">Total Devices</h4>
                                        <p class="item-figure text-info">{{$devices}} / {{$user->plan->limits->where('key', 'devices')->first()->value}}</p>
                                    </div>

                                    <div class="item item-comments  col-md-3 col-sm-6 col-xs-6">
                                        <h4 class="item-title">Price Plan</h4>
                                        <p class="item-figure text-purple">
                                            <a style="text-decoration:none;" href="{{route('profile.price')}}">
                                            {{$user->plan->plan->name}}
                                            </a></p>
                                    </div>

                                </div>

                            </div>


                            @if ($pushes->count() > 0)

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hash">Hash</th>
                                        <th class="client">Client/Device</th>
                                        <th class="mode">Mode</th>
                                        <th class="result">Result</th>
                                        <th class="updated">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($pushes as $push)



                                    <tr>
                                        <td class="number"><span class="label label-number">#{{str_limit($push->hash, 8,'...')}}</span></td>
                                        <td class="name">@if ($push->device)
                                            {{str_limit($push->device->user->name, 8, '...')}} /
                                            @if ($push->device->os == 'ios')<span class="fa fa-apple"></span> @elseif($push->device->os == 'android') <span class="fa fa-android"></span> @endif
                                        @else
                                        -
                                        @endif</td>

                                        <td class="priority">

                                            @if ($push->mode == 'code')
                                                <span class="label label-high">Code</span>
                                                @elseif($push->mode == 'push')
                                                <span class="label label-success">PushAuth</span>
                                            @elseif($push->mode == 'qr')
                                                <span class="label label-normal">QR-code</span>
                                                @endif




                                        </td>

                                        <td class="status">

                                            @if ($push->mode == 'code') <span class="label label-open">Success sended</span>



                                                @elseif ($push->mode == 'push')

                                                @if ($push->response_code == Null)
                                                    <span class="label label-todo">No response</span>
                                                    @else

                                                    @if($push->answer == 'true')
                                                        <span class="label label-open">Answered: YES</span>
                                                        @elseif( $push->answer == 'false')
                                                        <span class="label label-closed">Answered: NO</span>
                                                        @endif

                                                    @endif
                                            @elseif ($push->mode == 'qr')
                                                @if($push->response_code != Null)
                                                    <span class="label label-open">Used</span>
                                                    @else
                                                    <span class="label label-todo">Not using</span>
                                                    @endif

                                                @endif




                                        </td>

                                        <td class="updated">

                                            {{$push->created_at->diffForHumans()}}

                                        </td>
                                    </tr>
@endforeach
                                    </tbody>
                                </table>
                                <nav class="text-center pagination-wrapper">
                                    {{--<p class="pagination-info">Displaying pushes limit 10 of {{$pushesCount}}. For full information, change Price Plan.</p>--}}


                                    @if ($user->plan->plan->name == 'FREE')

                                    <div class="alert alert-theme alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <strong>Limits!</strong> Displaying pushes limit 10 of {{$pushesCount}}. For full information, change <a href="{{route('profile.price')}}">Price Plan</a>


                                    </div>

                                        @elseif ($user->plan->plan->name == 'PREMIUM')

                                        <span class="text-muted">* More information, you can view at <a href="{{route('appList')}}"> Application page</a>.</span>

                                    @endif


                                    {{--<ul class="pagination pagination-sm">
                                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                                    </ul>--}}
                                </nav>
                            </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-theme alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Howdy!</strong> You have not any pushes.

                                            @if ($user->app()->count() == 0 )<a href="{{route('appAdd')}}">Add App first now!</a>@endif
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>




<div class="module-content collapse in" id="content-7">
    <div class="module-content-inner no-padding-bottom">
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add first Application!</h4>
                    </div>
                    <div class="modal-body">
                        <p>For start use this service, you can create your first Application.</p>
                        <p>Or you can read API documentation for read how we use security fundamentals service and what we can make for you.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default-alt" data-dismiss="modal">Close</button>
                        <a href="{{route('appAdd')}}" class="btn btn-primary">Create Application</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>






@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')




<script>
    $(document).ready(function() {
        //startTour();
        @if ($user->app()->count() == 0 )
$("#myModal").modal('show');
        @endif

    });


</script>