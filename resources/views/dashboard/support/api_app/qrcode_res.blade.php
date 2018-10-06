<div class="module-wrapper">
    <a name="qr_res"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">QR code response</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">
                        <p>The response show <span class="label label-success">Request Hash</span> and <span class="label label-success">URL</span> to QR code image.

                        </p>


                        <div class="row">
                            <div class="col-md-6">



                                <div class="col-md-6"><h6>Content-Type:</h6>
                                    <p><code>application/json</code></p></div>
                                <div class="col-md-6"><h6>Response Code:</h6>
                                    <p><code>200 OK</code></p></div>




                                <div class="code-block">
                                    <h6>Body response example</h6>

                                    <pre><code class="json">{
"data":"YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd.29OakpvYmFkajZTYjdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq"
}</code></pre>



                                </div><!--//code-block-->
                                <div class="code-block">
                                    <h6><span class="label label-success">data</span> decoded json example</h6>

                                    <pre><code class="json">{
"req_hash":"12345678901234567890123456789012",
"qr_url":"https://api.pushauth.io/qr/show/image/somelongstringinbase64"
}</code></pre>



                                </div><!--//code-block-->

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
                                            <td><span class="label label-default">string</span></td>
                                            <th>req_hash</th>
                                            <td>Request hash for check state.</td>

                                        </tr>

                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>qr_url</th>
                                            <td>URL to QR-image.</td>

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