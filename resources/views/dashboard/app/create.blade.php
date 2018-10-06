@include('dashboard.layout.header')


{!! Html::style('assets/css/jasny-bootstrap.css') !!}
{!! Html::style('assets/css/dropzone.css') !!}

{!! Html::style('assets/css/bootstrap-tagsinput.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<style>
    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>
<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Application</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Add application</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">




                                @include('dashboard.layout.result_msg')








                                {!! Form::open(array('route' => 'appStore', 'autocomplete'=>'off', 'files'=> true, 'method'=>'PATCH')) !!}


                                <div class="row">
                                    <div class="col-md-3  text-center"><div class="form-group @if ($errors->has('app_img')) has-error @endif">
                                            <label class="label-control">Logo</label>
                                            <br>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <center>
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 80px;">
                                                        <img src="{{route('app.logo.show','default_app.png')}}">




                                                    </div>


                                                </center>
                                                <div>
                                                    <center>
                                                        @if ($errors->has('app_img')) <p class="help-block">{{ $errors->first('app_img') }}</p> @endif
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span>

                                                            {!! Form::file('app_img', ['id'=>'app_img']) !!}

													</span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </center>
                                                </div>
                                                <hr>


                                            </div>
                                        </div></div>
                                    <div class="col-md-9">




                                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                                            <label for="name">Name *</label>
                                            {!! Form::text('name', null, array('class'=>'form-control',
                                         'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'ex. MyServiceApp')) !!}
                                            <p class="help-block">Will be showing in mobile App. Max 24 char.</p>
                                            @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                        </div>

                                        <div class="form-group @if ($errors->has('about')) has-error @endif">
                                            <label for="about">About *</label>
                                            {!! Form::textarea('about', null, array('class'=>'form-control',
                                         'autocorrect'=>'off', 'autocapitalize'=>'off', 'rows'=>'3', 'autocomplete'=>'off', 'placeholder'=>'ex. https://example.com/')) !!}
                                            @if ($errors->has('about')) <p class="help-block">{{ $errors->first('about') }}</p> @endif
                                        </div>

                                        <div class="form-group @if ($errors->has('url')) has-error @endif">
                                            <label for="url">URL</label>
                                            {!! Form::text('url', null, array('class'=>'form-control',
                                         'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'ex. https://example.com/')) !!}
                                            @if ($errors->has('url')) <p class="help-block">{{ $errors->first('url') }}</p> @endif
                                        </div>

                                        <div class="form-group @if ($errors->has('ip_mask')) has-error @endif">
                                            <label for="ip_mask">IP address white list</label>
                                            <div class="row"><div class="col-md-12">
                                                    {!! Form::text('ip_mask', null, array('class'=>'form-control',
                                                 'autocorrect'=>'off', 'id'=>'ipmask', 'autocapitalize'=>'off','data-role'=>'tagsinput', 'autocomplete'=>'off', 'placeholder'=>'ex. 192.168.0.1', 'style'=>'width:100%')) !!}
                                                </div></div>
                                            <p class="help-block">If any IP-address setting, WhiteList will be enable.</p>
                                            @if ($errors->has('ip_mask')) <p class="help-block">{{ $errors->first('ip_mask') }}</p> @endif
                                        </div>





                                    </div>
                                </div>















<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <button type="submit" class="btn btn-block btn-success btn-lg">Create App!</button>
</div>
</div>




{!! Form::close() !!}








</div></div>
                    </div>
                </section>
            </div>
        </div>






    </div>
</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

{!! Html::script('assets/js/jasny-bootstrap.js') !!}
{!! Html::script('assets/js/jasny-bootstrap.js') !!}
{!! Html::script('assets/js/dropzone.js') !!}
{!! Html::script('assets/js/bootstrap-tagsinput.js') !!}


<script>
    $(document).ready(function() {



    });


</script>