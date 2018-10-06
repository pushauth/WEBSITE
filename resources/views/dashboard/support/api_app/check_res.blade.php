<div class="module-wrapper">
    <a name="check_res"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Check Auth response</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">
<p>The response from the server will be with the code 200 if the request is processed successfully, otherwise - see the error code.

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
"answered":true,
"answer":true,
"response_code":200,
"response_message":"Ok message!",
"response_dt":1234567,
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
                                            <th>data</th>
                                            <td>Encoded data string</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">boolean</span></td>
                                            <th>answered</th>
                                            <td>Status of client device response, <span class="label label-success">true</span> - if response exists, <span class="label label-success">false</span> - if not exists.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">boolean</span></td>
                                            <th>answer</th>
                                            <td>Response answer, <span class="label label-success">true</span> - if client clicked yes, <span class="label label-success">false</span> - if clicked no.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">integer</span></td>
                                            <th>response_code</th>
                                            <td>Code of response</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>response_message</th>
                                            <td>Response message</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">integer</span></td>
                                            <th>response_dt</th>
                                            <td>Date and time of client response. format <span class="label label-success">UNIX_TIMESTAMP</span> in UTC.</td>

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