@include('dashboard.layout.header')



@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Application</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-12">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Application created!</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="alert alert-pink alert-theme-solid alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <strong>Yeeah!</strong> Your Application is ready to use!
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">

                                    <h2><center>Your Personal API keys</center></h2>
<br>
                                    <div class="col-md-6">

                                        <div class="panel panel-success">
                                            <div class="panel-body">
                                                <center><strong id ="pk1"> {{$app->public_key}}</strong> <button id="btn1" type="button" alt="Copy to clipboard" data-clipboard-target="#pk1" class="btn btn-default btn-single-icon"><i class="fa fa-clipboard icon-single"></i></button>
                                                </center>
                                            </div>
                                            <div class="panel-footer">
                                                <center>  Public Key</center>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="panel panel-danger">
                                            <div class="panel-body">
                                                <center> <strong id ="pk2">{{$app->private_key}}</strong>
                                                    <button type="button" alt="Copy to clipboard" id="btn2" data-clipboard-target="#pk2" class="btn btn-default btn-single-icon"><i class="fa fa-clipboard icon-single"></i></button>
                                                </center>
                                            </div>
                                            <div class="panel-footer">
                                                <center>  Private Key</center>
                                            </div>
                                        </div>

                                    </div>

                                </div>





                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Information</h3>
                                    </div>
                                    <div class="panel-body">
                                        Please be sure, that your private key is stored in secure place. You can read API documentation for integrate your services or use libraries.
                                    </div>
                                </div>
                                {{--<div class="col-md-3">Public Key:</div>
                                <div class="col-md-7"> <p id="foo" class="bg-primary padding-sm">Nullam id dolor id nibh ultricies vehicula ut id elit.</p></div>
                                <div class="col-md-2"><button type="button" alt="Copy to clipboard" data-clipboard-target="#foo" class="btn btn-default btn-single-icon"><i class="fa fa-clipboard icon-single"></i></button></div>--}}







{{--

                                    <input id="foo" type="text" value="hello">
                                    <button id="btn" data-clipboard-action="copy" data-clipboard-target="#foo">Copy</button>
--}}





                            </div></div>

                    </div>
                </section>
            </div>
        </div>






    </div>
</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

{!! Html::script('assets/js/clipboard.js-master/dist/clipboard.min.js'); !!}

<script>
    $(document).ready(function() {
        var clipboard1 = new Clipboard('#btn1');
        var clipboard2 = new Clipboard('#btn2');

        /*clipboard.on('success', function(e) {
            console.log(e);
        });*/
    });
</script>