@include('dashboard.layout.header')
{!!  Html::style('assets/css/account.css') !!}



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
                            <div class="content-header-wrapper">
                                <h2 class="title">My Notifications</h2>

                            </div>


                            @if($user->notifications()->where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() > 0)


                            <div class="table-responsive">
                                <table class="table">

                                    <tbody>


@foreach( $user->notifications()->where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->orderBy('id','desc')->get() as $notify)

                                    <tr>

                                        <th scope="row"> <span class="pe-icon pe-7s-info icon"></span> <a href ="{{route('profile.notify.show',$notify->urlhash)}}">{{str_limit($notify->subject, '50', '...')}}</a></th>
                                        <td class="text-right"> <small>{{$notify->created_at->diffForHumans()}} </small></td>


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
                                            <strong>Howdy!</strong> You have not any notifications.
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

