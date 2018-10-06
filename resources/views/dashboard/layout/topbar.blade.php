<header class="header">
    <div class="branding float-left">
        <h1 class="logo text-center">
            <a href="{{route('frontend.index')}}">
                <img class="logo-icon" src="{{url('/assets/images/logo_white_small.png')}}">
               {{-- <img class="logo-icon" src="assets/images/logo-icon.svg" alt="icon" />--}}
                <span class="nav-label" style="
    font-size: 25px;
">
							<span class="highlight" >Push</span>Auth
						</span>
            </a>
        </h1>
    </div>
    <div class="topbar">
        <button id="main-nav-toggle" class="main-nav-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <i class="icon fa fa-caret-left"></i>
        </button>
{{--        <div class="search-container">
            <form id="main-search" class="main-search">
                <i id="main-search-toggle" class="fa fa-search icon"></i>
                <div id="main-search-input-wrapper" class="main-search-input-wrapper">
                    <input type="text" id="main-search-input" class="main-search-input form-control" placeholder="Search...">

                    <span id="clear-search" aria-hidden="true" class="fs1 icon icon_close_alt2 clear-search"></span>
                </div>
            </form>
        </div>--}}
        <div class="navbar-tools">
            <div class="utilities-container">
                <div class="utilities">
                    <div id="tour-trigger" class="item item-tour hidden-xs tour-trigger" data-toggle="tooltip" data-placement="bottom" title="Guided Tour"><span class="sr-only">App Tour</span><span class="pe-icon pe-7s-info icon"></span></div>



                {{--@if (Session::has('returnToAdmin'))
                        <li>
                            <a href="{{route('admin.login.admin')}}"
                               class="btn btn-danger btn-xs"><i class="fa fa-sign-out "></i>
                                Return to Admin Area</a>




                        </li>
                    @endif--}}




                    <div class="item item-notifications">
                        <div class="dropdown-toggle" id="dropdownMenu-notifications" data-toggle="dropdown" aria-expanded="true" role="button">
                            <span class="sr-only">Notifications</span>
                            <span class="pe-icon pe-7s-bell icon" data-toggle="tooltip" data-placement="bottom" title="Notifiations"></span><span class="badge badge-circle badge-danger">@if ($user->notificationsFlagRead('false')->count() > 0) {{$user->notificationsFlagRead('false')->count()}} @endif</span>
                        </div>
                        <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-notifications">
                            <span class="arrow"></span>
                            <div class="notification-items no-overflow">

                                @foreach($user->notificationsFlagRead('false')->orderBy('id', 'desc')->take(3)->get() as $notify)
                                    <div class="item media">
                                        <div class="media-left profile">
                                            <span class="pe-icon pe-7s-info icon"></span>
                                        </div>
                                        <div class="media-body">
                                            <a href="{{route('profile.notify.show', $notify->urlhash)}}">
                                                <span class="action">{{str_limit($notify->subject,'30','...')}}</span><br> {{str_limit(strip_tags($notify->body),'100','...')}}
                                            </a>
                                        </div>
                                        <div class="meta">
                                            {{$notify->created_at->diffForHumans()}}
                                        </div>
                                    </div>
                                    @endforeach












                            </div>
                            <div class="dropdown-footer">
                                <a href="{{route('profile.notify')}}">View all notifications</a>
                            </div>
                        </div>
                    </div>
                    {{--<div class="item item-messages dropdown">
                        <div class="dropdown-toggle" id="dropdownMenu-messages" data-toggle="dropdown" aria-expanded="true" role="button">
                            <span class="sr-only">Messages</span>
                            <span class="pe-icon pe-7s-mail icon" data-toggle="tooltip" data-placement="bottom" title="Messages"></span><span class="badge badge-circle badge-success">5</span>
                        </div>
                        <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-messages">
                            <span class="arrow"></span>
                            <div class="message-items no-overflow">
                                <div class="item media">
                                    <div class="media-left profile">
                                        <img class="profile" src="assets/images/profiles/profile-7.png" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <a href="#">
                                            <span class="sender display-block">Julia Arnold</span>
                                            <span class="message-title display-block">Great News</span>
                                            <span class="excerpt display-block">"Hey Becky, thanks for doing this natoque penatibus et magnis dis parturient montes..."</span>
                                        </a>
                                    </div>
                                    <div class="meta">
                                        Apr 6
                                    </div>
                                </div>
                                <div class="item media">
                                    <div class="media-left profile">
                                        <img class="profile" src="assets/images/profiles/profile-1.png" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <a href="#">
                                            <span class="sender display-block">Ken Davison</span>
                                            <span class="message-title display-block">RE: Help Needed</span>
                                            <span class="excerpt display-block">"No problem. I can help with the luctus est eu ullamcorper laoreet..."</span>
                                        </a>
                                    </div>
                                    <div class="meta">
                                        Apr 2
                                    </div>
                                </div>
                                <div class="item media">
                                    <div class="media-left profile">
                                        <img class="profile" src="assets/images/profiles/profile-4.png" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <a href="#">
                                            <span class="sender display-block">Ryan Baker</span>
                                            <span class="message-title display-block">RE: UX resources for Nike</span>
                                            <span class="excerpt display-block">"Hi Becky, can you send me the wireframes? I need the finalised version..."</span>
                                        </a>
                                    </div>
                                    <div class="meta">
                                        Mar 28
                                    </div>
                                </div>
                                <div class="item media">
                                    <div class="media-left profile">
                                        <img class="profile" src="assets/images/profiles/profile-5.png" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <a href="#">
                                            <span class="sender display-block">Sarah West</span>
                                            <span class="message-title display-block">Hello!</span>
                                            <span class="excerpt display-block">"Hello there, lorem ipsum dolor sit amet, consectetur adipiscing elit duis luctus..."</span>
                                        </a>
                                    </div>
                                    <div class="meta">
                                        Mar 25
                                    </div>
                                </div>
                                <div class="item media">
                                    <div class="media-left profile">
                                        <img class="profile" src="assets/images/profiles/profile-6.png" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <a href="#">
                                            <span class="sender display-block">Carl Wilson</span>
                                            <span class="message-title display-block">RE: Design Resource</span>
                                            <span class="excerpt display-block">"Hi, Phasellus cursus libero quis ante commodo lobortis duis ac ante..."</span>
                                        </a>
                                    </div>
                                    <div class="meta">
                                        Mar 25
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a href="user-messages.html">View all messages</a>
                            </div>
                        </div>
                    </div>--}}
 {{--                   <div class="item item-more dropdown">
                        <div class="dropdown-toggle" id="dropdownMenu-more" data-toggle="dropdown" aria-expanded="true" role="button">
                            <span class="sr-only">More</span>
                            <span aria-hidden="true" class="fs1 icon icon_grid-3x3" data-toggle="tooltip" data-placement="bottom" title="Settings &amp; Tools"></span>
                        </div>
                        <div class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-more">
                            <span class="arrow"></span>
                            <h4 class="title">Settings &amp; Tools</h4>
                            <ul class="more-list">
                                <li><a role="menuitem" href="user-settings.html"><span class="pe-icon pe-7s-config icon"></span><br>Settings</a></li>
                                <li><a role="menuitem" href="user-billing.html"><span class="pe-icon pe-7s-wallet icon"></span><br>Billing</a></li>
                                <li><a role="menuitem" href="user-drive.html"><span class="pe-icon pe-7s-pendrive icon"></span><br>Drive</a></li>
                                <li><a role="menuitem" href="user-messages.html"><span class="pe-icon pe-7s-chat icon"></span><br>Messages</a></li>
                                <li><a role="menuitem" href="user-reminders.html"><span class="pe-icon pe-7s-clock icon"></span><br>Reminders</a></li>

                                <li><a role="menuitem" href="help.html"><span class="pe-icon pe-7s-help2 icon"></span><br>Help</a></li>
                            </ul>
                        </div>
                    </div>--}}
                </div>
            </div>
            <div class="user-container dropdown">
                <div class="dropdown-toggle" id="dropdownMenu-user" data-toggle="dropdown" aria-expanded="true" role="button">
                    <img src="{{$user->img}}" alt="" />
                    <i class="fa fa-caret-down"></i>
                </div>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-user" >
                    <li><span class="arrow"></span><a role="menuitem" href="{{route('profile')}}"><span class="pe-icon pe-7s-user icon"></span>My Account</a></li>
                    {{--<li><a role="menuitem" href="pricing.html"><span class="pe-icon pe-7s-paper-plane icon"></span>Upgrade Plan</a></li>--}}
                    <li><a role="menuitem" href="{{route('logout')}}"><span class="pe-icon pe-7s-power icon"></span>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>