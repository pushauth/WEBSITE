@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}



@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">Application - {{$app->name}}</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">


                @include('dashboard.layout.result_msg')


                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.app.appinfo')

                            @include('dashboard.app.menu')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Clients</h2>
                            <hr>
                            @if ($clients->count() > 0)



                                @if ($user->plan->plan->name == 'FREE')
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>

                                            <th class="client">Address</th>
                                            <th class="mode">Devices</th>
                                            <th class="updated">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($clients as $client)
                                            <tr>
                                                <td class="client"><span class="label label-number">{{str_limit($client->email, 8,'...')}}</span></td>
                                                <td class="mode">{{$client->devices->count()}}</td>


                                                <td class="status">

                                                    @if ($client->status == 'enable')
                                                        <label class="label label-success">enable</label>
                                                    @elseif($client->status == 'disable')
                                                        <label class="label label-danger">disable</label>
                                                    @endif



                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <nav class="text-center pagination-wrapper">
                                        {{--<p class="pagination-info"></p>--}}
                                        <div class="alert alert-theme alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Limits!</strong> Displaying pushes limit 5 of {{$app->pushRequests->count()}}. For full information, change <a href="{{route('profile.price')}}"> Price Plan</a>.
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
                                        <table id="datatables-1" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Address</th>
                                                <th>Devices</th>
                                                <th>Status</th>


                                            </tr>
                                            </thead>
                                            <tbody style="
    font-size: 13px;
"></tbody>

                                            <tbody>



                                            </tbody>
                                        </table>
                                    </div>




                                    @endif







                            @else
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-theme alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Oops!</strong> You have not any clients.


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


<script>
    $(document).ready(function() {
        'use strict';

        $('#datatables-1').DataTable({
            "processing": true,
            "stateSave": true,
            "serverSide": true,
            //"searchDelay": 500,
            "order": [[ 1, "desc" ]],
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ],
            "ajax": {
                "url": "{{route('app.show.clients.ajax', $app->urlhash)}}",
                "type": "POST"
            },
            "columns": [
                { "data": "1" },
                { "data": "2" },
                { "data": "3" }
            ]
        });


    });

</script>