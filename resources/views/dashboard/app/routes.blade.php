@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}
{!! Html::style('assets/css/bootstrap-switch.css') !!}
{!!  Html::style('assets/css/switchery.css') !!}


<style>
    td.details-control {
        background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
</style>


@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper view view-account">
    <div class="container-fluid">
        <h2 class="view-title">Application - {{$app->name}}</h2>
        <div class="row">
            <div class="module-wrapper col-lg-12 col-md-12 col-sm-12 col-xs-12">





                <section class="module">
                    <div class="module-inner">
                        <div class="side-bar">
                            @include('dashboard.app.appinfo')








                            @include('dashboard.app.menu')

                        </div>

                        <div class="content-panel">
                            <h2 class="title">Push Routes</h2>
                            <hr>
                            @include('dashboard.layout.result_msg')










@if ($user->plan->plan->name == 'FREE')

                             <div class="alert alert-theme alert-warning alert-dismissible" role="alert">
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 <strong>Limits!</strong> Upgrade your <a href="{{route('profile.price')}}">Price Plan</a> for available Push Routes.
                             </div>
@else
                            <p>
                                You can use Push Routes service. For more information, please read API documentation.
                            </p>


                                <div class="table-responsive">
                                    <table id="datatables-1" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Hash</th>
                                            <th>Clients</th>
                                            <th>Devices</th>
                                            <th>Answer</th>
                                            <th>Date</th>

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
                            <hr>






                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
{!! Html::script('assets/js/switchery.js') !!}
{!! Html::script('assets/js/bootstrap-switch.js') !!}
<script>
    $(document).ready(function() {
        'use strict';

        var table = $('#datatables-1').DataTable({
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
                "url": "{{route('app.show.routes.ajax', $app->urlhash)}}",
                "type": "POST"
            },
            "columns": [
                {
                    className:      'details-control',
                    orderable:      false,
                    data:           null,
                    defaultContent: ''
                },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" }
            ]
        });



        $('#datatables-1').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        });

        function format ( d ) {



            var itemRes = "";



        $.each(d.c, function(i, item) {

           // console.log(item.client);

            itemRes = itemRes + '<tr>'+
                    '<td>'+item.order+'</td>'+
                    '<td>'+item.client+'</td>'+
                    '<td>'+item.device+'</td>'+
                    '<td>'+item.status+'</td>'+
                    '<td>'+item.answer+'</td>'+
                    '</tr>';
           // console.log(itemRes);

            });



            // `d` is the original data object for the row
            return '<table class="table table-bordered table-hover"  style="padding-left:50px;">'+

                    '<tr>'+
                    '<th>Order</th>'+
                    '<th>Client</th>'+
                    '<th>Device</th>'+
                    '<th>Status</th>'+
                    '<th>Answer</th>'+
                    '</tr>'+
                    itemRes+

                    '</table>';
        }

        $(".bootstrap-switch").bootstrapSwitch();
        /*new Switchery(
         document.querySelector('.switchery-success'), {color: '#75c181', size: 'small' }
         );*/
        var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-success'));

        elems.forEach(function(html) {
            var switchery = new Switchery(html, {color: '#75c181', size: 'small' });
        })
    });
</script>

