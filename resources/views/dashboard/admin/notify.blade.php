@include('dashboard.layout.header')



{!!  Html::style('assets/css/tickets.css') !!}
{!!  Html::style('assets/css/dashboard-hosting.css') !!}
{!! Html::style('assets/css/bootstrap-switch.css') !!}

{!! Html::style('assets/css/select2.css') !!}


@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')



<div id="content-wrapper" class="content-wrapper view tickets-view projects-view">
    <div class="container-fluid">
        <div class="projects-heading">
            <h2 class="view-title">Notify System</h2>

        </div>
        <div class="clearfix"></div>
        <div class="row">





            <div class="module-wrapper col-md-12 col-sm-12 col-xs-12">






                <section class="module tickets-module">
                    <div class="module-inner">
                        {{--<div class="module-heading">
                            --}}{{--<h3 class="title">Total information</h3>--}}{{--
                        </div>--}}
                        <div class="module-content">
                            <div class="module-content-inner no-padding-bottom">
                                @include('dashboard.layout.result_msg')






                                {!! Form::open(array('route' => 'admin.notify.store', 'autocomplete'=>'off')) !!}

                                <div class="form-group">
                                    <label class="col-md-1" for="wait_response" >To *</label>

<div class="col-md-2"> {!! Form::checkbox('mode_to', 'enable',null,['data-off-text'=>'SELECTED', 'data-size'=>'small', 'data-on-text'=>'ALL', 'class'=>'bootstrap-switch form-control', 'id'=>'wait_response']) !!}</div>

                                    <div class="col-md-9">

                                        {!! Form::select('client[]',$client, $clientArr, array('class'=>'form-control input-sm js-data-client', 'style'=>'width: 100%', 'multiple'=>'multiple', 'data-placeholder'=>'List of clients')) !!}

                                    </div>

                                </div>


                                {{--<div class="form-group @if ($errors->has('to')) has-error @endif">
                                    <label for="to">To *</label>
                                    {!! Form::text('to', '', array('class'=>'form-control',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'placeholder'=>'ex. MyServiceApp')) !!}







                                    @if ($errors->has('to')) <p class="help-block">{{ $errors->first('to') }}</p> @endif
                                </div>--}}

                                <div class="form-group @if ($errors->has('subject')) has-error @endif">
                                    <label for="subject">Subject *</label>
                                    {!! Form::text('subject', '', array('class'=>'form-control',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off')) !!}
                                    @if ($errors->has('subject')) <p class="help-block">{{ $errors->first('subject') }}</p> @endif
                                </div>


                                <div class="form-group @if ($errors->has('body')) has-error @endif">
                                    <label for="body">Body *</label>
                                    {!! Form::textarea('body', '', array('class'=>'form-control',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'autocomplete'=>'off', 'id'=>'wysihtml5-editor', 'rows'=>'10')) !!}

                                    {{--<textarea name="body" id="wysihtml5-editor" rows="10" class="form-control"></textarea>--}}
                                    @if ($errors->has('body')) <p class="help-block">{{ $errors->first('body') }}</p> @endif
                                </div>




<hr>


                                <div class="form-group">
                                    <label  for="wait_response" >With mail</label>

                                   {!! Form::checkbox('with_mail', 'enable',null,['data-off-text'=>'no', 'data-size'=>'small', 'data-on-text'=>'yes', 'class'=>'bootstrap-switch form-control', 'id'=>'wait_response']) !!}


                                </div>



                                <div class="form-group @if ($errors->has('email_body')) has-error @endif">
                                    <label for="email_body">Body(email) *</label>
                                    {!! Form::textarea('email_body', '', array('class'=>'form-control',
                                 'autocorrect'=>'off', 'autocapitalize'=>'off', 'rows'=>'3', 'autocomplete'=>'off')) !!}
                                    @if ($errors->has('email_body')) <p class="help-block">{{ $errors->first('email_body') }}</p> @endif
                                </div>




                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-block btn-success btn-lg">Store notify!</button>
                                    </div>
                                </div>




                                {!! Form::close() !!}




                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>









@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

{!! Html::script('assets/js/bootstrap-switch.js') !!}
{!! Html::script('assets/js/select2.js') !!}



<script>
    $(document).ready(function() {


        $(".bootstrap-switch").bootstrapSwitch();


        function formatRepo (repo) {
            if (repo.loading) return repo.text;

            var markup = "<div class='select2-result-repository clearfix'>" +
                   // "<div class='select2-result-repository__avatar'><img src='" + repo.img + "' /></div>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" + repo.name + "</div>";

            if (repo.id) {
                markup += "<div class='select2-result-repository__description'>" + repo.position + "</div>";
            }

            markup +=
                    "</div>" +
                    "</div></div>";

            return markup;
        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }


        $(".js-data-client").select2({
            allowClear: true,
            ajax: {
                type: "POST",
                url: "{{ route('admin.ajax.users.json') }}",
                dataType: 'json',
                allowClear: true,
                placeholder: "Select an attribute",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        })

        ;
        /*$('#wysihtml5-editor').wysihtml5({
         toolbar: {
         "fa": true
         }
         });*/
    });

    </script>



