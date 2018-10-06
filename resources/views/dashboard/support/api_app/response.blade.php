<div class="module-wrapper">
    <a name="response"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Response</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">



<p>The response from the server will be with the code 200 if the push is successful, otherwise see the error codes.
</p>

<div class="row">
<div class="col-md-6">

                            <h5 class="block-title">Response</h5>

                            <div class="col-md-6"><h6>Content-Type:</h6>
                                <p><code>application/json</code></p></div>
                            <div class="col-md-6"><h6>Response Code:</h6>
                                <p><code>200 OK</code></p></div>




                            <div class="code-block">
                                <h6>Body response example</h6>

                                <pre><code class="json">{
"message":"Success push created!",
"data":"YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYm.FkajZTYjdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq"
}</code></pre>



                            </div><!--//code-block-->
                            <div class="code-block">
                                <h6><span class="label label-success">data</span> decoded json example</h6>
                                <pre><code class="json">{
"req_hash":"someUniqCodeHash",
"answer":true
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
                                        <th>message</th>
                                        <td>Message with error description.</td>

                                    </tr>
                                    <tr>
                                        <td><span class="label label-default">string</span></td>
                                        <th>data</th>
                                        <td>JSON-encoded data, with key/values.</td>

                                    </tr>
                                    <tr>
                                        <td><span class="label label-default">string</span></td>
                                        <th>req_hash</th>
                                        <td>A unique request hash, through which you can check the status of the authorization request</td>

                                    </tr>
                                    <tr>
                                        <td><span class="label label-default">boolean</span></td>
                                        <th>answer</th>
                                        <td>Client answer. <span class="label label-success">true</span> - if clicked yes, <span class="label label-success">false</span> - if clicked no.</td>

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