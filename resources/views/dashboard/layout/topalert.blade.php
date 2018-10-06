{{--
<div id="top-alert" class="alert alert-promo alert-dismissible fade in text-center" role="alert" style="">
    <span id="top-alert-close" aria-hidden="true" class="icon icon_close close"></span>
    <strong>Welcome to AppKit!</strong> Your trial will run out in 30 days
    <a class="btn btn-warning btn-sm margin-left-sm" href="pricing.html">Upgrade Now</a>
</div>--}}

@if (Session::has('returnToAdmin'))
    <div id="top-alert" class="alert alert-promo alert-dismissible fade in text-center" role="alert" style="">

         You login as user <strong>{{$user->name}}</strong> and you can
        <a class="btn btn-warning btn-sm margin-left-sm" href="{{route('admin.login.admin')}}">return to admin area</a>
    </div>

@endif