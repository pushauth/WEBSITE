<div class="main-nav-wrapper">
    <nav id="main-nav" class="main-nav js-cloak">
        <ul id="menu">
            <li  class="nav-dashboards {{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}">
                    <span aria-hidden="true" class="icon icon_house_alt"></span>
                    <span class="nav-label">Dashboards</span>

                </a>

            </li>
            <li  class="nav-widgets nav-app-pages  {{ Route::currentRouteNamed('appList') ? 'active' : '' }}">
                <a href="{{route('appList')}}">
                    <span aria-hidden="true" class="icon fa fa-cube"></span>
                    <span class="nav-label">App</span>
                    @if ($user->app->count() > 0)
                    <span class="badge badge-primary">{{$user->app->count()}}</span>
                        @endif
                </a>
            </li>
{{--            <li  class=" ">
                <a href="{{route('testList')}}">
                    <span aria-hidden="true" class="icon icon_box-checked"></span>
                    <span class="nav-label">Test App</span>
                </a>
            </li>--}}


            <li  class="nav-app-pages  ">
                <a href="#">
                    <span aria-hidden="true" class="icon icon_box-checked"></span>
                    <span class="nav-label">Sandbox</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="sub-menu {{ Route::currentRouteNamed('testList') ? 'collapse in' : '' }} {{ Route::currentRouteNamed('test.server') ? 'collapse in' : '' }}">
                    <li  class="{{ Route::currentRouteNamed('testList') ? 'active' : '' }} ">
                        <a href="{{route('testList')}}">
                            <span class="nav-label">App</span>
                        </a>
                    </li>
                    <li  class="{{ Route::currentRouteNamed('test.server') ? 'active' : '' }} ">
                        <a href="{{route('test.server')}}">
                            <span class="nav-label">Server side</span>
                        </a>
                    </li>
                    </ul>
            </li>

            <li role="presentation" class="divider ">
            </li>




            <li  class=" nav-support-pages {{ Route::currentRouteNamed('support') ? 'active' : '' }} {{ Route::currentRouteNamed('support.api') ? 'active' : '' }} {{ Route::currentRouteNamed('support.libraries') ? 'active' : '' }}">
                <a href="#">
                    <span aria-hidden="true" class="icon icon_lifesaver"></span>
                    <span class="nav-label">Support</span>
                    <span class="fa arrow"></span>
                    {{--<span class="label label-new">NEW</span>--}}
                </a>
                <ul class="sub-menu {{ Route::currentRouteNamed('support.ticket.create') ? 'collapse in' : '' }}{{ Route::currentRouteNamed('support.ticket.index') ? 'collapse in' : '' }} {{ Route::currentRouteNamed('support.api') ? 'collapse in' : '' }} {{ Route::currentRouteNamed('support.libraries') ? 'collapse in' : '' }} ">

                    <li  class=" {{ Route::currentRouteNamed('support.ticket.create') ? 'active' : '' }}{{ Route::currentRouteNamed('support.ticket.index') ? 'active' : '' }} ">
                        <a href="{{route('support.ticket.index')}}">
                            <span class="nav-label">Requests</span>
                            @if ($user->tickets()->whereIn('status',['open','work'])->count() > 0)
                                <span class="badge badge-primary">{{$user->tickets()->whereIn('status',['open','work'])->count()}}</span>
                            @endif
                        </a>
                    </li>

                    <li  class=" {{ Route::currentRouteNamed('support.api') ? 'active' : '' }} ">
                        <a href="{{route('frontend.content.api')}}">
                            <span class="nav-label">API Documentation</span>
                        </a>
                    </li>
                    <li  class=" {{ Route::currentRouteNamed('support.libraries') ? 'active' : '' }} ">
                        <a href="{{route('support.libraries')}}">
                            <span class="nav-label">Libraries</span>
                        </a>
                    </li>
                    </ul>
            </li>

            @if ($user->role->role == 'admin')
                <li role="presentation" class="divider ">
                </li>




                <li  class="nav-admin-pages  ">
                    <a href="#">
                        <span aria-hidden="true" class="icon icon_shield"></span>
                        <span class="nav-label">Admin</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="sub-menu collapse in ">
                        <li  class="{{ Route::currentRouteNamed('admin.index') ? 'active' : '' }} ">
                            <a href="{{route('admin.index')}}">
                                <span class="nav-label">Dashboard</span>
                            </a>
                        </li>
                        <li  class="{{ Route::currentRouteNamed('admin.users') ? 'active' : '' }} ">
                            <a href="{{route('admin.users')}}">
                                <span class="nav-label">Users</span>
                            </a>
                        </li>


                        <li  class="{{ Route::currentRouteNamed('admin.plans') ? 'active' : '' }} ">
                            <a href="{{route('admin.plans')}}">
                                <span class="nav-label">Price Plans</span>
                            </a>
                        </li>


                        <li  class="{{ Route::currentRouteNamed('admin.apps') ? 'active' : '' }} ">
                            <a href="{{route('admin.apps')}}">
                                <span class="nav-label">Apps</span>
                            </a>
                        </li>
                        <li  class="{{ Route::currentRouteNamed('admin.devices') ? 'active' : '' }} ">
                            <a href="{{route('admin.devices')}}">
                                <span class="nav-label">Devices</span>
                            </a>
                        </li>
                        <li  class="{{ Route::currentRouteNamed('admin.pushes') ? 'active' : '' }} ">
                            <a href="{{route('admin.pushes')}}">
                                <span class="nav-label">Pushes</span>
                            </a>
                        </li>
                        <li  class="{{ Route::currentRouteNamed('admin.notify') ? 'active' : '' }} ">
                            <a href="{{route('admin.notify')}}">
                                <span class="nav-label">Notify's</span>
                            </a>
                        </li>
                        <li  class="{{ Route::currentRouteNamed('admin.tickets') ? 'active' : '' }} ">
                            <a href="{{route('admin.tickets')}}">
                                <span class="nav-label">Tickets</span>
                            </a>
                        </li>
                        {{--<li  class=" ">
                            <a href="stats">
                                <span class="nav-label">Stats</span>
                            </a>
                        </li>--}}
                    </ul>
                </li>
                @endif


        </ul>
    </nav>
</div>