<nav class="side-menu">
    <ul class="nav">
        <li class="{{ Route::currentRouteNamed('app.show') ? 'active' : '' }}"><a href="{{route('app.show',$app->urlhash)}}"><span class="pe-icon pe-7s-info icon"></span> Information</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.pushes') ? 'active' : '' }}"><a href="{{route('app.show.pushes', $app->urlhash)}}"><span class="pe-icon pe-7s-chat icon"></span> Pushes</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.clients') ? 'active' : '' }}"><a href="{{route('app.show.clients',$app->urlhash)}}"><span class="pe-icon pe-7s-user icon"></span> Clients</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.devices') ? 'active' : '' }}"><a href="{{route('app.show.devices',$app->urlhash)}}"><span class="pe-icon pe-7s-phone icon"></span> Devices</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.hooks') ? 'active' : '' }}"><a href="{{route('app.show.hooks', $app->urlhash)}}"><span class="pe-icon pe-7s-gleam icon"></span> Web Hooks</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.routes') ? 'active' : '' }}"><a href="{{route('app.show.routes', $app->urlhash)}}"><span class="pe-icon pe-7s-way icon"></span> Push Routes</a></li>

        <li class="{{ Route::currentRouteNamed('app.show.settings') ? 'active' : '' }}"><a href="{{route('app.show.settings',$app->urlhash)}}"><span class="pe-icon pe-7s-config icon"></span> Settings</a></li>


    </ul>
</nav>