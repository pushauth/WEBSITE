@foreach (['danger', 'warning', 'success', 'info', 'pink', 'purple', 'yellow'] as $msg)
    @if(Session::has('alert-' . $msg))
        <div class="alert alert-theme alert-{{$msg}} alert-theme-solid alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{ Session::get('alert-' . $msg) }}
        </div>
    @endif
@endforeach