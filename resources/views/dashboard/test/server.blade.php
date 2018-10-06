@include('dashboard.layout.header')

{!! Html::style('assets/css/bootstrap-switch.css') !!}

@include('dashboard.layout.topalert')

@include('dashboard.layout.topbar')

@include('dashboard.layout.leftbar')

<div id="content-wrapper" class="content-wrapper">
    <div class="container-fluid">
        <h2 class="view-title">Test server</h2>


        <div id="masonry" class="row">
            <div class="module-wrapper masonry-item col-md-6">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">Base64 testing</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="string" class="col-sm-3 control-label">Your string (text)</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="string" placeholder="Some text">
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                        <button type="button" id="sendBase64" class="btn btn-default"><i class="fa fa-check"></i>Show!</button>
                                            </div>

                                        <div class="col-sm-9">
                                            <div class="well well-sm" id="resBase64" style="    word-break: break-all;">
                                                empty
                                            </div>
                                        </div>


                                    </div>
                                    </form>
                                <div class="option-divider"><span>Detail</span></div>
                                <p>
                                    We used PHP function <a href="http://php.net/manual/function.base64-encode.php">base64_encode</a>.
                                </p>


                            </div></div>

                    </div>
                </section>
            </div>
            <div class="module-wrapper masonry-item col-md-6">
                <section class="module module-headings">
                    <div class="module-inner">
                        <div class="module-heading">
                            <h3 class="module-title">HMAC in Base64 testing</h3>


                        </div>
                        <div class="module-content collapse in" id="content-1">
                            <div class="module-content-inner no-padding-bottom">



                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="stringHMAC" class="col-sm-3 control-label">Your string (text)</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="stringHMAC" placeholder="Some text">
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <label for="pass" class="col-sm-3 control-label">Your password</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="pass" placeholder="Public Key or Private Key">
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <button type="button" id="sendHMACBase64" class="btn btn-default"><i class="fa fa-check"></i>Show!</button>
                                        </div>

                                        <div class="col-sm-9">
                                            <div class="well well-sm" id="resHMAC" style="    word-break: break-all;">
                                                empty
                                            </div>
                                        </div>


                                    </div>
                                </form>
                                <div class="option-divider"><span>Detail</span></div>
                                <p>
                                    We used PHP functions <a href="http://php.net/manual/function.hash-hmac.php">hash_hmac</a> and <a href="http://php.net/manual/function.base64-encode.php">base64_encode</a>. First, we encode string with algo SHA-256 and password and get binary data. After that, binary data pack in base64.
                                </p>






                            </div></div>

                    </div>
                </section>




            </div>







        </div>






    </div>
</div>



@include('dashboard.layout.sidebar')

@include('dashboard.layout.footer')

<script>
    $(document).ready(function() {

        $('body').on('click', '#sendBase64', function(event) {
            event.preventDefault();

            var str = $("#string").val();

            $.ajax({
                type: "POST",
                url: "{{route('test.server.base64') }}",
                data: {
                    _token : CSRF_TOKEN,
                    str : str


                },
                error :function( jqXhr ) {
                    if( jqXhr.status === 422 ) {
                        //process validation errors here.
                        var errors = jqXhr.responseJSON;

                        errorsHtml = '<div class="text-danger">';
                        $.each( errors , function( key, value ) {
                            errorsHtml += value[0] + '<br>'; //showing only the first error.
                        });
                        errorsHtml += 'Stopped! </div>';
                        $("#resBase64").append(errorsHtml);
                    }

                },
                success: function(data) {




                    $("#resBase64").html(data.msg);


                }
            });


        });

        $('body').on('click', '#sendHMACBase64', function(event) {
            event.preventDefault();
            var str = $("#stringHMAC").val();
            var pass = $("#pass").val();

            $.ajax({
                type: "POST",
                url: "{{route('test.server.hmac') }}",
                data: {
                    _token : CSRF_TOKEN,
                    str : str,
                    pass: pass


                },
                error :function( jqXhr ) {
                    if( jqXhr.status === 422 ) {
                        //process validation errors here.
                        var errors = jqXhr.responseJSON;

                        errorsHtml = '<div class="text-danger">';
                        $.each( errors , function( key, value ) {
                            errorsHtml += value[0] + '<br>'; //showing only the first error.
                        });
                        errorsHtml += 'Stopped! </div>';
                        $("#resHMAC").append(errorsHtml);
                    }

                },
                success: function(data) {




                    $("#resHMAC").html(data.msg);


                }
            });
        });

    });
</script>