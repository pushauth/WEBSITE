<div class="user-info">
    <img class="img-profile img-circle img-responsive center-block" src="{{$user->img}}" alt="" />
    <ul class="meta list list-unstyled">
        <li class="name">{{$user->name}}
            {{--<label class="label label-info">Free Plan</label>--}}
        </li>
        <li class="email"><a href="#">{{$user->profile->company or ''}}</a></li>
        <li class="activity"><small>Last logged in: {{$user->logins()->orderBy('id','desc')->first()->created_at->format('l jS \\of F Y H:i:s ')  }} (UTC)</small></li>
    </ul>
</div>