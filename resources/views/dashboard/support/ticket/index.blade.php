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
            <h2 class="view-title">Online Support</h2>
        </div>
        <div class="clearfix"></div>
        <div class="row" >

            <div class="col-wrapper col-md-12 col-sm-12 col-xs-12 " >
                <div class="module-wrapper " id="navs" data-spy="" data-offset-top="0" style="top: 10px;">
                    <section class="module commits-module " >
                        <div class="module-inner" >
                            <div class="module-heading">
                                <h3 class="module-title">Recent requests</h3>
                                <ul class="actions list-inline">
                                    <li><a href="{{route('support.ticket.create')}}" class="btn btn-sm btn-primary" style="color: white;" href="#" ><span class="fa fa-question"></span> Submit Request</a></li>
                                    </ul>
                            </div>

                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom">
                                    @include('dashboard.layout.result_msg')



                                    @if ($user->tickets->count() > 0 )



                                        <div class="table-responsive">
                                            <table id="datatables-1" class="table table-striped display">
                                                <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Answers</th>
                                                    <th>Date</th>

                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Status</th>
                                                    <th>Answers</th>
                                                    <th>Date</th>

                                                </tr>
                                                </tfoot>
                                                <tbody>


                                                @foreach($user->tickets()->orderBy('id','desc')->get() as $ticket)
                                                    <tr>
                                                        <td><strong><a href="{{route('support.ticket.show', $ticket->url_hash)}}">{{
                                                        str_limit($ticket->subject,'32','...')
                                                        }}</a></strong></td>
                                                        <td>

                                                            @if ($ticket->status == 'open')
                                                                <span class="text-danger">open</span>
                                                            @elseif($ticket->status == 'work')
                                                                <span class="text-pink">work</span>
                                                            @elseif($ticket->status == 'close')
                                                                <span class="text-success">close</span>
                                                            @endif


                                                        </td>
                                                        <td>
                                                            <i class="fa fa-comment"></i>
                                                            {{$ticket->threads->count()}}

                                                        </td>
                                                        <td>{{$ticket->created_at->diffForHumans()}}</td>

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
                                                    <strong>Howdy!</strong> You have not any tickets. <a href="{{route('support.ticket.create')}}">Create first now!</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif




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

    });

</script>

