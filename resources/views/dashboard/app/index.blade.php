
@include('dashboard.layout.header')






@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Application</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Application list</h3>
                            <ul class="actions list-inline">
                                @if ($user->plan->plan->name == 'FREE')
                                    @if ($user->app->count() >= $user->plan->limits->where('key', 'apps')->first()->value)


                                        <li><a id="UIappLimit" class="btn btn-sm btn-primary" style="color: white;" href="#" ><span class="fa fa-cube"></span> Create new App</a></li>




                                    @else
                                        <li><a class="btn btn-sm btn-primary" style="color: white;" href="{{route('appAdd')}}" ><span class="fa fa-cube"></span> Create new App</a></li>
                                        @endif


                                    @else
                                    <li><a class="btn btn-sm btn-primary" style="color: white;" href="{{route('appAdd')}}" ><span class="fa fa-cube"></span> Create new App</a></li>
                                @endif





                            </ul>

                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">

                                @include('dashboard.layout.result_msg')


                                @if($user->app->count() > 0)
                                    <div class="table-responsive">
                                        <table id="datatables-1" class="table table-striped display">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Pushes</th>
                                                <th>IP List</th>
                                                <th>Test</th>
                                                <th>Keys</th>
                                                <th>Settings</th>
                                                <th>Destroy</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Pushes</th>
                                                <th>IP List</th>
                                                <th>Test</th>
                                                <th>Keys</th>
                                                <th>Settings</th>
                                                <th>Destroy</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>


                                    @foreach($user->app as $app)
                                        <tr>
                                            <td><strong><a href="{{route('app.show', $app->urlhash)}}">{{ $app->name }}</a></strong></td>
                                            <td>
                                                @if ($app->status == 'enable')
                                                <span class="label label-success">Enable</span>
                                                @else
                                                <span class="label label-danger">Disable</span>
                                                @endif
                                            </td>
                                            <td>{{ $app->pushRequests()->where('test','false')->whereIn('mode',['code','push'])->count() }}</td>
                                            <td>
                                                @if ($app->ip_mask == Null)
                                                    <span class="label label-low">
                                                        <span class="fa fa-unlock"></span>
                                                    </span>
                                                    @else
                                                    <span class="label label-normal">
                                                        <span class="fa fa-lock"></span>
                                                    </span>
                                                @endif

                                            </td>
                                            <td><a style="    font-size: 10px; " href="{{ route('testList', [$app->urlhash]) }}" class="btn btn-default btn-xs"><i class="fa fa-play-circle"></i>Test Now!</a></td>
                                            <td><button type="button" data-app-hash="{{$app->urlhash}}" class="btn btn-default btn-xs showModal"><i class="fa fa-refresh"></i>Generate</button></td>
                                            <td>

                                                <a style="    color: #fff; font-size: 10px; border: 1px solid #58bbee;" href="{{route('app.show.settings',[$app->urlhash])}}" class="btn btn-info btn-xs"><i class="fa fa-cog"></i>Edit</a>

                                            </td>

                                            <td>

                                                <button type="button" id="deleteApp" data-app-hash="{{$app->urlhash}}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button>

                                            </td>
                                        </tr>
                                        @endforeach
</tbody>
                                            </table>
                                        </div>

                                    @else

                        <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                        <div class="alert alert-theme alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong>Howdy!</strong> You have not any application. <a href="{{route('appAdd')}}">Add first now!</a>
                        </div>
                    </div>
                    </div>
                                @endif




                                </div></div>

                        </div>
                    </section>
                </div>
            </div>






    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">API keys will be regenerated</h4>
            </div>
            <div class="modal-body">
                Are you sure re-generate new pairs of keys? Because your App with older keys will be not work.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-alt" data-dismiss="modal">No</button>
                <button type="button" id="makeNewKeys" data-app-hash="" class="btn btn-primary">Yes, i'm sure!</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delete App?</h4>
            </div>
            <div class="modal-body">
                Are you really want to delete App? Because your will never restored.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-alt" data-dismiss="modal">No</button>
                <button type="button" id="makeDeleteApp" data-app-hash="" class="btn btn-primary">Yes, i'm sure!</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalKeys" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Your Personal API keys</h4>
            </div>
            <div class="modal-body">


                <div class="row">

                    <div class="col-md-12">

                        <div class="panel panel-success">
                            <div class="panel-body">
                                <center><strong id ="pk1"> </strong> <button id="btn1" type="button" alt="Copy to clipboard" data-clipboard-target="#pk1" class="btn btn-default btn-single-icon"><i class="fa fa-clipboard icon-single"></i></button>
                                </center>
                            </div>
                            <div class="panel-footer">
                                <center>  Public Key</center>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="panel panel-danger">
                            <div class="panel-body">
                                <center> <strong id ="pk2"></strong>
                                    <button type="button" alt="Copy to clipboard" id="btn2" data-clipboard-target="#pk2" class="btn btn-default btn-single-icon"><i class="fa fa-clipboard icon-single"></i></button>
                                </center>
                            </div>
                            <div class="panel-footer">
                                <center>  Private Key</center>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id = "closeApi" class="btn btn-default-alt">Close</button>
               {{-- <button type="button" class="btn btn-primary">Yes, i'm sure!</button>--}}
            </div>
        </div>
    </div>
</div>
<div class="module-content collapse in" id="content-7">
    <div class="module-content-inner no-padding-bottom">
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="myModalCreateApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

        <div class="modal fade" id="modalUIappLimit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Application limit!</h4>
                    </div>
                    <div class="modal-body">
                        <p>In your price plan you can create only 1 application.</p>
                        <p>For more applications, change <a href="{{route('profile.price')}}">Price Plan</a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default-alt" data-dismiss="modal">Close</button>
                        <a href="{{route('profile.price')}}" class="btn btn-primary">Change plan</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

{!! Html::script('assets/js/clipboard.js-master/dist/clipboard.min.js'); !!}

<script>
    $(document).ready(function() {
        'use strict';
       // $('#myModalKeys').modal('show');
        /* ======= DataTables ====== */
        /* Ref: http://www.datatables.net/ */
        $('#datatables-1').DataTable();

        var clipboard1 = new Clipboard('#btn1');
        var clipboard2 = new Clipboard('#btn2');

        //showModal
        $('body').on('click', '.showModal', function(event) {
            event.preventDefault();

            $('#myModal').modal('show');
            $('#makeNewKeys').attr('data-app-hash', $(this).attr('data-app-hash'));

        });

        $('body').on('click', '#makeNewKeys', function(event) {
            event.preventDefault();
            $('#myModal').modal('hide');
            var hash= $(this).attr('data-app-hash');

            $.ajax({
                type: "POST",
                url: "{{route('app.newKeys') }}",
                data: {
                    _token : CSRF_TOKEN,
                    app_hash : hash
                },
                success: function(data) {
                    //console.log(data.a);
                    $("#pk1").text(data.pk1);
                    $("#pk2").text(data.pk2);
                    $('#myModalKeys').modal('show');
                }
            });



            //


        });


        @if ($user->app()->count() == 0 )
$("#myModalCreateApp").modal('show');
        @endif



        $('body').on('click', '#closeApi', function(event) {
            event.preventDefault();
            $('#myModalKeys').modal('hide');
            $("#pk1").text('trololo');
            $("#pk2").text('trololo too');
            });

        //UIappLimit
        $('body').on('click', '#UIappLimit', function(event) {
            event.preventDefault();

            $('#modalUIappLimit').modal('show');

        });

        $('body').on('click', '#deleteApp', function(event) {
            event.preventDefault();
            $('#makeDeleteApp').attr('data-app-hash', $(this).attr('data-app-hash'));
            $('#myModalDelete').modal('show');

        });

        $('body').on('click', '#makeDeleteApp', function(event) {
            event.preventDefault();
            $('#myModalDelete').modal('hide');
            var hash= $(this).attr('data-app-hash');

            window.location = '{{route('app.delete',Null)}}/'+hash;






            //


        });

    });

</script>