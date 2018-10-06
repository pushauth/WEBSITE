<div class="module-wrapper">
    <a name="check_req"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Check request status</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">

<p>After the successful push request for authorization has been successfully sent, you can request the status of the authorization request using the previously obtained authorization request hash.</p>

                        <div class="row">
                            <div class="col-md-1">
                                <h6>Method:</h6>
                                <p><code>POST</code></p>
                            </div>
                            <div class="col-md-11">
                                <h6>API Endpoint:</h6>
                                <p><code>https://api.pushauth.io/push/status</code></p>
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
"data":"YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29Oak.pvYmFkajZTYjdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq"
}</code></pre>
                                </div><!--//code-block-->

                                <div class="code-block">
                                    <h6><span class="label label-success">data</span> decoded json example</h6>
                                    <pre><code class="json">{
"req_hash":"someUniqReqHash"
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
                                            <th>pk</th>
                                            <td>Your application public key.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>data</th>
                                            <td>JSON-encoded data.</td>
                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>req_hash</th>
                                            <td>A unique authorization request hash, through which you can check the status of the authorization request.</td>

                                        </tr>


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