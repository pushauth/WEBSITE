@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')




<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Apps</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Apps list</h3>

                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">

                                @include('dashboard.layout.result_msg')










                                <div class="table-responsive">
                                    <table id="datatables-1" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Pushes</th>
                                            <th>Devices</th>
                                            <th>User</th>
                                            <th>Status</th>
                                           {{-- <th class="no-sort">Config</th>
                                            <th class="no-sort">Destroy</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody style="
    font-size: 13px;
"></tbody>

                                        <tbody>



                                        </tbody>
                                    </table>
                                </div>











                                {{--<div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-theme alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Howdy!</strong> You have not any users.
                                        </div>
                                    </div>
                                </div>--}}





                            </div></div>

                    </div>
                </section>
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

</script>