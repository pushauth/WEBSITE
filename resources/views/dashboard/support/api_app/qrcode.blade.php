<div class="module-wrapper">
    <a name="qr_req"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Auth by QR-code</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">
                        <h4>You can use QR-code auth in your application. You show only QR-code and your client scan it by PushAuth mobile Application, and you can identify client.</h4>


                        <p>
                            This request allows you to get <span class="label label-success">Request Hash</span>, for check autorization status and <span class="label label-success">QR-code</span> URL image for showing on your application.
                        </p>


                        <div class="row">
                            <div class="col-md-1">
                                <h6>Method:</h6>
                                <p><code>POST</code></p>
                            </div>
                            <div class="col-md-11">
                                <h6>API Endpoint:</h6>
                                <p><code>https://api.pushauth.io/qr/show</code></p>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-md-6">
                                <h6>Content-Type:</h6>
                                <p><code>application/json</code></p>
                                <div class="code-block">
                                    <h6>Body request example</h6>
                                    <pre><code class="json">{
"pk":"56a24f5f9ee389dd88e4e071ce7fe67a",
"data":"YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFkaj.ZTYjdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq"
}</code></pre>
                                </div><!--//code-block-->
                                <div class="code-block">
                                    <h6><span class="label label-success">data</span> decoded json example</h6>
                                    <pre><code class="json">{
"image":{
    "size":"128",
    "color":"40,0,40",
    "backgroundColor":"255,255,255",
    "margin":"1"
         }
}</code></pre>
                                </div><!--//code-block-->
                                <div class="col-md-12">
                                    <div class="callout-block callout-info">
                                        <div class="icon-holder">
                                            <i class="fa fa-info"></i>
                                        </div><!--//icon-holder-->
                                        <div class="content">

                                            <p>You can use additional parameters for customize QR-code image.</p>
                                        </div><!--//content-->
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">


                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Param</th>
                                            <th>Description</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><span class="label label-default">json array</span></td>
                                            <th>image</th>
                                            <td>All available parameters for image customize</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span> or <span class="label label-default">integer</span></td>
                                            <th>size</th>
                                            <td>Image size in px.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>color</th>
                                            <td>Image color in RGB.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>backgroundColor</th>
                                            <td>Image background color in RGB.</td>

                                        </tr>

                                        <tr>
                                            <td><span class="label label-default">string</span> or <span class="label label-default">integer</span></td>
                                            <th>margin</th>
                                            <td>QR margin at image (1..10)</td>

                                        </tr>


                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>







                    </div>



                </div>
            </div>
        </div>
    </section>
</div>