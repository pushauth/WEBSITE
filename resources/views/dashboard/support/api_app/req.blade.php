<div class="module-wrapper">
    <a name="req"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Sending request</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">
                        <h4>Sending PUSH-request for your client</h4>


                        <p>
                            This request allows you to send a push request, using PushAuth, to your client, knowing it <span class="label label-success">email-address</span>, to mobile device and receive response.
                            Your client must have installed mobile iOS or Android app with logged <span class="label label-success">email</span>
                        </p>


                        <div class="row">
                            <div class="col-md-1">
                                <h6>Method:</h6>
                                <p><code>POST</code></p>
                            </div>
                            <div class="col-md-11">
                                <h6>API Endpoint:</h6>
                                <p><code>https://api.pushauth.io/push/send</code></p>
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
"address_to":"client@yoursite.com",
"mode":"push",
"code":"123-456",
"flash_response":false
}</code></pre>
                                </div><!--//code-block-->
                                <div class="col-md-12">
                                    <div class="callout-block callout-info">
                                        <div class="icon-holder">
                                            <i class="fa fa-info"></i>
                                        </div><!--//icon-holder-->
                                        <div class="content">

                                            <p>If you use <code class="json" style="font-size: 10px">"flash_response":"false"</code>, the response are received by you only if client mobile device answered. Otherwise, if the response from the client does not arrive within 30 seconds, you will receive a response with a <code>request hash</code> that will later be able to track the status of the response.</p>
                                        </div><!--//content-->
                                    </div>
                                    <div class="callout-block callout-info">
                                        <div class="icon-holder">
                                            <i class="fa fa-info"></i>
                                        </div><!--//icon-holder-->
                                        <div class="content">

                                            <p>If you use <code class="json" style="font-size: 10px">"mode":"code"</code>, <code class="json" style="font-size: 10px">"flash_response":"false"</code> are ignored.</p>
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
                                            <td><span class="label label-default">string</span></td>
                                            <th>pk</th>
                                            <td>Your application public key</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>data</th>
                                            <td>JSON-encoded string, with key/values.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>address_to</th>
                                            <td>E-mail address of client device app.</td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">string</span></td>
                                            <th>mode</th>
                                            <td>Mode of push request. Available: <span class="label label-success">push</span> - push request with question (yes or no) or <span class="label label-success">code</span> - for sending code value.</td>

                                        </tr>

                                        <tr>
                                            <td><span class="label label-default">string(8)</span></td>
                                            <th>code</th>
                                            <td>Code/text/char or ..., that be displayed at client device application, only if selected <span class="label label-success">mode</span> = <span class="label label-success">code</span></td>

                                        </tr>
                                        <tr>
                                            <td><span class="label label-default">boolean</span></td>
                                            <th>flash_response</th>
                                            <td>Mode of server response. If <span class="label label-success">true</span> - then immediately, after sending a push request, you will receive a response with a request hash that you can then check the status of the response from your client (his device). If <span class="label label-success">false</span> - then after sending a push request, the server will wait for a response from your client (his device) within 30 seconds. If the answer is not received, during this time - you will receive a response from the server. </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>

<div class="">
    <h5  class="block-title">Code example</h5>


    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist1">
            <li role="presentation" class="active"><a href="#home1" aria-controls="home1" role="tab" data-toggle="tab">PHP</a></li>
            <li role="presentation"><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">BASH</a></li>
            {{--<li role="presentation"><a href="#messages1" aria-controls="messages1" role="tab" data-toggle="tab">C++</a></li>
            <li role="presentation"><a href="#settings1" aria-controls="settings1" role="tab" data-toggle="tab">Java</a></li>--}}
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel1" class="tab-pane active" id="home1">


                                                <pre><code class="php">//Setting data params
$data = json_encode(['address_to'     => 'client@mysite.com',
                     'mode'           => 'push',
                     'code'           => '123-456',
                     'flash_response' => true]);
//Encode data

$encodedData = base64_encode($data);
$signature = base64_encode(hash_hmac('sha256',$encodedData,'myPrivateKey',true));
//Prepare request json
$requestArray = json_encode(['pk'   => 'myPublicKey',
                 'data' => $encodedData.'.'.$signature]);

$ch = curl_init('https://api.pushauth.io/push/send');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestArray);
curl_setopt($ch, CURLOPT_TIMEOUT, 100000);
$result = curl_exec($ch);

if (curl_errno($ch)) {
   throw new \Exception(curl_error($ch));
}
curl_close($ch);  // Seems like good practice
print_r($result);
/*
[
"message" =>"Success push created!",
"data"    =>"YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFkajZTYj.dTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq"
]
*/

</code></pre>


            </div>
            <div role="tabpanel1" class="tab-pane" id="profile1">

<pre><code class="bash">#!/bin/bash

#Private Key
pass='BCTmUYdzOERpNjGIMoxGKQk0IRAArLnJ'

#Public Key
ppass='BCTmUYdzOERpNjGIMoxGKQk0IRAArLnJ'


encstring=$(echo -ne "{\"address_to\":\"client@yoursite.com\",\"mode\":\"push\",\"code\":\"123-456\",\"flash_response\":true}" | base64)


hmac=$(echo "$encstring" | openssl dgst -sha256 -hex -hmac "$ppass")
enchmac=$(echo -ne "$hmac" | base64)
prestr=${encstring}.${enchmac}

curl -v -g -H "Content-Type: application/json" -X POST --data "{\"pk\":\"${ppass}\",\"data\":\"${prestr}\"}" "http://localhost/api/push/send"


</code>
    </pre>




            </div>
            <div role="tabpanel1" class="tab-pane" id="messages1">...</div>
            <div role="tabpanel1" class="tab-pane" id="settings1">...</div>
        </div>

    </div>


</div>





                    </div>



                </div>
            </div>
        </div>
    </section>
</div>