@include('dashboard.layout.header')

{!!  Html::style('assets/js/highlight/styles/tomorrow.css') !!}
{!!  Html::style('assets/css/bootstrap-datepicker.css') !!}

{!!  Html::style('assets/css/discussion.css') !!}


@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<style>

</style>







<div id="content-wrapper" class="content-wrapper view project-single-view" >
    <div class="container-fluid">
        <div class="project-heading">
            <h2 class="view-title">Ticket #{{str_limit($ticket->url_hash,6,'')}}</h2>
        </div>
        <div class="clearfix"></div>
        <div class="row" >

            <div class="col-wrapper col-md-12 col-sm-12 col-xs-12 " >
                <div class="module-wrapper " id="navs" data-spy="" data-offset-top="0" style="top: 10px;">
                    <section class="module commits-module " >
                        <div class="module-inner" >


                            <div class="module-heading">
                                <h3 class="module-title">{{str_limit($ticket->subject)}}</h3>
                                <ul class="actions list-inline">
                                    <li>{{$ticket->type}}</li>
                                    <li>@if ($ticket->status == 'open')
                                            <span class="text-danger">[ open ] </span>
                                        @elseif($ticket->status == 'work')
                                            <span class="text-pink">[ work ]</span>
                                        @elseif($ticket->status == 'close')
                                            <span class="text-success">[ close ]</span>
                                        @endif</li>





                                </ul>

                            </div>

                            <div class="module-content">
                                <div class="module-content-inner no-padding-bottom" style="padding-top: 0px;">

                                    @include('dashboard.layout.result_msg')


                                    <div class="">
                                        <div class="topic-holder">
                                            <div class="topic-author">
                                                <img class="img-responsive img-circle" src="@if ($ticket->client->profile->user_img == Null)
                                                {{route('profile.showImage', 'default_avatar.png') }}
                                                @else
                                                {{route('profile.showImage', $ticket->client->profile->user_img) }}
                                                @endif" alt="">
                                            </div>
                                            <div class="topic-content-wrapper">
                                                <cite class="name"><a href="{{route('admin.user.show',$ticket->client->id)}}">{{$ticket->client->email}}</a> started the topic with subject: <strong>{{$ticket->subject}}</strong></cite>
                                                <p class="time">at {{$ticket->created_at->toDayDateTimeString()

                                               }}</p>
                                                <div class="topic-content">
                                                    <p>{!! nl2br($ticket->text) !!}</p>
                                                    @if($ticket->error_msg)
                                                        <br>
                                                        <p><strong>Error message:</strong><br><code>{{$ticket->error_msg}}</code> </p>

                                                    @endif
                                                    @if($ticket->app_id)
                                                        <p><strong>Application:</strong> {{$ticket->app->name}} [{{$ticket->app->urlhash}}]</p>
                                                    @endif
                                                    @if($ticket->issue_dt)
                                                        <p><strong>Issue Day ~:</strong> {{$ticket->issue_dt}}</p>
                                                    @endif


                                                    @if ($ticket->files()->Img('false')->count() > 0)
                                                        <div class="size-13 margin-bottom-30">
                                        <span class="size-11 margin-bottom-8 bold block">{{$ticket->files()->Img('false')->count()}}
                                            attachments</span>

                                                            @foreach($ticket->files()->Img('false')->get() as $file)

                                                                <div><!-- attachment -->
                                                                    <i class="fa fa-download text-muted"></i> &nbsp;
                                                                    <a href="{{route('support.ticket.file.download', $file->hash)}}">{{$file->name}}</a>
                                                                </div><!-- /attachment -->
                                                            @endforeach

                                                        </div>
                                                    @endif

                                                    @if ($ticket->files()->Img('true')->count() > 0)
                                                        <div class="size-12 lightbox"
                                                             data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>

                                        <span class="size-11 margin-bottom-8 bold block"><strong>{{$ticket->files()->Img('true')->count()}}
                                                images:</strong></span><br>

                                                            @foreach($ticket->files()->Img('true')->get() as $file)
                                                                <a href="{{route('support.ticket.file.download', $file->hash)}}">

                                                                    <img src="{{route('support.ticket.file.download.image', $file->hash)}}"
                                                                         alt="image"/>
                                                                </a>
                                                            @endforeach


                                                        </div>
                                                    @endif



                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        @if ($ticket->threads->count() > 0)
                                            <div class="comment-list" style="margin-bottom: 0px; ">
                                                <h3 class="title">Discussions</h3>
                                                {{--<div class="comment-item depth-1 parent">
                                                    <div class="comment-item-box">
                                                        <div class="comment-author">
                                                            <img class="img-responsive img-circle" src="assets/images/profiles/profile-6.png" alt="">
                                                        </div>
                                                        <div class="comment-body">
                                                            <cite class="name">Dominic White posted:</cite>
                                                            <p class="time">Mar 21, 2016 at 3:16pm</p>
                                                            <div class="content">
                                                                <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</p>
                                                            </div>
                                                            <a class="comment-reply-link btn btn-default" href="#">Reply</a>
                                                        </div>
                                                    </div>

                                                </div>--}}

                                                @foreach($ticket->threads()->orderBy('id','asc')->get() as $thread)

                                                    <div class="comment-item depth-1 parent">
                                                        <div class="comment-item-box"
                                                             @if ($thread->author->role->role == 'admin')
                                                             style="border:1px solid #fac8fb"
                                                                @endif
                                                        >
                                                            <div class="comment-author">
                                                                <img class="img-responsive" src="@if ($thread->author->profile->user_img == Null)
                                                                {{route('profile.showImage', 'default_avatar.png') }}
                                                                @else
                                                                {{route('profile.showImage', $thread->author->profile->user_img) }}
                                                                @endif "
                                                                     alt="">
                                                            </div>
                                                            <div class="comment-body">
                                                                <cite class="name">{{$thread->author->profile->first_name}} {{$thread->author->profile->last_name}} posted:</cite>
                                                                <p class="time">{{$thread->created_at->toDayDateTimeString()}}</p>
                                                                <div class="content">
                                                                    <p>{!! nl2br($thread->text) !!}</p>

                                                                    @if ($thread->files()->Img('false')->count() > 0)
                                                                        <div class="size-13 margin-bottom-30">
                                        <span class="size-11 margin-bottom-8 bold block">{{$thread->files()->Img('false')->count()}}
                                            attachments</span>

                                                                            @foreach($thread->files()->Img('false')->get() as $file)

                                                                                <div><!-- attachment -->
                                                                                    <i class="fa fa-download text-muted"></i> &nbsp;
                                                                                    <a href="{{route('support.ticket.file.download', $file->hash)}}">{{$file->name}}</a>
                                                                                </div><!-- /attachment -->
                                                                            @endforeach

                                                                        </div>
                                                                    @endif

                                                                    @if ($thread->files()->Img('true')->count() > 0)
                                                                        <div class="size-12 lightbox"
                                                                             data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>

                                        <span class="size-11 margin-bottom-8 bold block"><strong>{{$thread->files()->Img('true')->count()}}
                                                images:</strong></span><br>

                                                                            @foreach($thread->files()->Img('true')->get() as $file)
                                                                                <a href="{{route('support.ticket.file.download', $file->hash)}}">

                                                                                    <img src="{{route('support.ticket.file.download.image', $file->hash)}}"
                                                                                         alt="image"/>
                                                                                </a>
                                                                            @endforeach


                                                                        </div>
                                                                    @endif

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                {{--<nav class="text-center pagination-wrapper">
                                                    <p class="pagination-info">Displaying posts 1-6 of 36</p>
                                                    <ul class="pagination pagination-sm">
                                                        <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                                        <li><a href="#">2</a></li>
                                                        <li><a href="#">3</a></li>
                                                        <li><a href="#">4</a></li>
                                                        <li><a href="#">5</a></li>
                                                        <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                                    </ul>
                                                </nav>--}}
                                            </div>
                                            <hr>

                                        @endif


                                        @if ($ticket->status != 'close')

                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <a href="{{route('admin.ticket.work', $ticket->url_hash)}}" type="button" class="btn btn-block btn-warning btn-lg">Status: work</a>

                                                    <a href="{{route('admin.ticket.close', $ticket->url_hash)}}" type="button" class="btn btn-block btn-pink btn-lg">Close ticket</a>
                                                    <br>
                                                </div>
                                            </div>

                                            <div class="reply-holder">
                                                <h4 class="title">Leave answer</h4>
                                                <div class="reply-content">
                                                    <div class="author">
                                                        <img src="{{$user->img}}" alt="" />
                                                        <center>You</center>
                                                    </div>
                                                    <div class="form-holder">


                                                        {!! Form::open(array('route' => ['admin.ticket.answer',$ticket->url_hash], 'autocomplete'=>'off', 'files'=> true, 'method'=>'PATCH', 'class'=>'margin-bottom-lg')) !!}

                                                        <div class="row">
                                                            <div class="form-group @if ($errors->has('body')) has-error @endif">

                                                                <div class="col-sm-12">
                                                                    {!! Form::textarea('body', Null, array('class'=>'form-control',
                                                                 'autocorrect'=>'off','placeholder'=>'Type your comment...', 'autocapitalize'=>'off', 'autocomplete'=>'off','rows'=>'8')) !!}
                                                                    @if ($errors->has('body')) <p class="help-block">{{ $errors->first('body') }}</p> @endif
                                                                </div>

                                                                <div class="form-group  @if ($errors->has('files')) has-error @endif">

                                                                    <div class="col-sm-12">
                                                                        {!! Form::file('files[]', array('class'=>'form-control','placeholder'=>'Add files...','multiple'=>true)) !!}
                                                                        @if ($errors->has('files')) <p class="help-block">{{ $errors->first('files') }}</p> @endif
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12"><br></div>
                                                                <div class="col-md-6 col-md-offset-3">

                                                                    <button type="submit" class="btn btn-block btn-primary">Add answer</button>

                                                                </div>
                                                            </div>

                                                        </div>
                                                        {!! Form::close() !!}


                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>



                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>






            </div>
        </div>
    </div>
</div>







@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')
{!! Html::script('assets/js/highlight/highlight.pack.js') !!}
{!! Html::script('assets/js/bootstrap-datepicker.js') !!}



<script>
    $(document).ready(function() {
        'use strict';
        $('#datepicker1').datepicker({
            todayBtn: "linked",
            calendarWeeks: true,
            format:"dd-mm-yyyy",
            autoclose: true,
            keyboardNavigation: false,
            todayHighlight: true
        });
    });

</script>

