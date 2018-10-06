<div class="user-info">
    @if ($app->img == Null)
            <img  class="img-profile img-circle img-responsive center-block" src="{{route('app.logo.show','default_app.png')}}">
    @else
        <img  class="img-profile img-circle img-responsive center-block" src="{{route('app.logo.show',$app->img)}}">
    @endif
    <ul class="meta list list-unstyled">
        <li class="name">{{$app->name}}
            {{--<label class="label label-info">Free Plan</label>--}}
        </li>
        <li class="name">
            @if($app->status == 'enable')<label class="label label-success">enable</label>

            @else <label class="label label-danger">disable</label>

            @endif</li>
        <li class="activity"><small>Created at: {{$app->created_at->format('l jS \\of F Y H:i:s ')  }} (UTC)</small></li>
    </ul>
</div>