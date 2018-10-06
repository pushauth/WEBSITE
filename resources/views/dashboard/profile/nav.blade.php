<nav class="side-menu">
    <ul class="nav">
        <li class="{{ Route::currentRouteNamed('profile') ? 'active' : '' }}"><a href="{{route('profile')}}"><span class="pe-icon pe-7s-user icon"></span> Profile</a></li>
        <li class="{{ Route::currentRouteNamed('profile.security') ? 'active' : '' }}"><a href="{{route('profile.security')}}"><span class="pe-icon pe-7s-shield icon"></span> Security</a></li>

        <li class="{{ Route::currentRouteNamed('profile.price') ? 'active' : '' }}"><a href="{{route('profile.price')}}"><span class="pe-icon pe-7s-edit icon"></span> Price Plan</a></li>

        <li class="{{ Route::currentRouteNamed('profile.billing') ? 'active' : '' }}"><a href="{{route('profile.billing')}}"><span class="pe-icon pe-7s-credit icon"></span> Billing</a></li>

        <li class="{{ Route::currentRouteNamed('profile.notify') ? 'active' : '' }}"><a href="{{route('profile.notify')}}"><span class="pe-icon pe-7s-bell icon"></span> Notifications</a></li>

    </ul>
</nav>