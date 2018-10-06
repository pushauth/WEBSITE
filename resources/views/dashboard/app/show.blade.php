@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}
{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}
{!!  Html::style('assets/css/dashboard-projects.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">Application - {{$app->name}}</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">


                @include('dashboard.layout.result_msg')


                <section class="module module-projects-overview">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.app.appinfo')

                            @include('dashboard.app.menu')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Information</h2>
<hr>


                            <ul class="data-list row text-center">
                                <li class="item item-1 col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                    <a href="{{route('app.show.pushes', $app->urlhash)}}">
                                        <span aria-hidden="true" class="icon pe-7s-chat"></span>
                                        <span class="data">{{$app->pushRequests()->where('test','false')->whereIn('mode', ['code','push'])->count()}}</span>
                                        <span class="desc">total pushes</span>
                                    </a>
                                </li>
                                <li class="item item-2 col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                    <a href="{{route('app.show.devices', $app->urlhash)}}">
                                        <span aria-hidden="true" class="icon pe-7s-phone"></span>
                                        <span class="data">{{$devices}}</span>
                                        <span class="desc">total devices</span>
                                    </a>
                                </li>
                                <li class="item item-3 col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                    <a >
                                        <span aria-hidden="true" class="icon pe-7s-users"></span>
                                        <span class="data">{{$clients}}</span>
                                        <span class="desc">total clients</span>
                                    </a>
                                </li>
                                <li class="item item-4 col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                    <a >
                                        <span aria-hidden="true" class="icon pe-7s-repeat"></span>
                                        <span class="data">{{$app->pushRequests()->where('test','false')->whereIn('mode',['code','push','route','qr'])->whereNotNull('device_id')->count()}}</span>
                                        <span class="desc">total requests</span>
                                    </a>
                                </li>
                            </ul>

<hr>


                            @if ($app->pushRequests->count() > 0)


                                @if ($user->plan->plan->name == 'FREE')

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

                                        @foreach($app->pushRequests()->whereIn('mode',['code','push','qr'])->orderBy('id','desc')->take(5)->get() as $push)
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
                                        {{--<p class="pagination-info"></p>--}}




                                            <div class="alert alert-theme alert-warning alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <strong>Limits!</strong> Displaying pushes limit 10 of {{$app->pushRequests->count()}}. For full information, change <a href="{{route('profile.price')}}">Price Plan</a>


                                            </div>









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

                                    @elseif ($user->plan->plan->name == 'PREMIUM')


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

                                            @foreach($app->pushRequests()->whereIn('mode',['code','push','qr'])->orderBy('id','desc')->take(10)->get() as $push)
                                                <tr>
                                                    <td class="number"><span class="label label-number"
                                                        >


                                                            #{{str_limit($push->hash, 8,'...')}}


                                                        </span></td>
                                                    <td class="name">@if ($push->device)
                                                                         <span data-html="true" data-toggle="tooltip"
                                                                               title="
                                                      Name: {{$push->device->name or "-"}}<br>
                                                      Vendor: {{$push->device->vendor or "-"}}<br>
                                                      OS: {{$push->device->os_detail or "-"}}<br>">


                                                            {{str_limit($push->device->user->name, 8, '...')}} /
                                                            @if ($push->device->os == 'ios')<span class="fa fa-apple"></span> @elseif($push->device->os == 'android') <span class="fa fa-android"></span> @endif
                                                                             </span>
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
                                            {{--<p class="pagination-info"></p>--}}


<span class="text-muted">* showed last 10. More information at <a href="{{route('app.show.pushes', [$app->urlhash])}}">Pushes page</a>.</span>











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
                                    {{--<div class="table-responsive">
                                        <table id="datatables-1" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Hash</th>
                                                <th>Client/Device</th>
                                                <th>Mode</th>
                                                <th>Result</th>
                                                <th>Date</th>

                                            </tr>
                                            </thead>
                                            <tbody style="
    font-size: 13px;
"></tbody>

                                            <tbody>



                                            </tbody>
                                        </table>
                                    </div>--}}


                                    @endif




                            @else
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-theme alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Oops!</strong> You have not any pushes.


                                        </div>
                                    </div>
                                </div>
                            @endif






                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')


{{--

<script>
    $(document).ready(function() {
        'use strict';

        $('#datatables-1').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            //"searchDelay": 500,
            "order": [[ 4, "desc" ]],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "ajax": {
                "url": "{{route('admin.ajax.apps')}}",
                "type": "POST"
            },
            "columns": [
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" }
            ]
        });


    });

</script>--}}
