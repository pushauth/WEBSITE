<div class="module-wrapper">
    <a name="decoding"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">Decoding data</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">



                        <div class="">
                            <h3 id="auth-decode-section" class="block-title">Algorithm for decoding a string</h3>
                            <div class="section-block">

                                We have a private key.

                                <h4>The order of actions</h4>
                                <ol class="list">
                                    <li>We have encoded string, example: <pre>YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFkajZTY.jdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq</pre> </li>

                                    <li>We split the line using the dot separator symbol into two lines. The first part of it will be <strong>data</strong>, and second - <strong>HMAC-signature</strong>. At result,<br> data: <pre>YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFkajZTY</pre>
                                        and signature: <pre>jdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq</pre></li>
                                    <li>Decode <strong>data</strong> by Base64 function. And we receive json.</li>

                                    <li>
                                        To verify the validity of the data, we generate HMAC signature. To do this, we use the data encoded in base64 (example YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFkajZTY), algorithm sha-256 and private key.
                                        And the result encode in base64.
                                    </li>

                                    <li>
                                        Now we need to compare: our generated HMAC and HMAC, obtained from the answer.
                                                                                 If they coincide, then you can trust the answer.



                                    </li>
                                </ol>


                            </div>
                        </div>


                        <div class="">
                            <h5  class="block-title">Code example</h5>


                            <div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home-res" aria-controls="home" role="tab" data-toggle="tab">PHP</a></li>
                                    <li role="presentation"><a href="#bash" aria-controls="bash" role="tab" data-toggle="tab">BASH</a></li>
                                    <li role="presentation"><a href="#cpp" aria-controls="cpp" role="tab" data-toggle="tab">C++</a></li>
                                    <li role="presentation"><a href="#java" aria-controls="java" role="tab" data-toggle="tab">Java</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home-res">


                                                <pre><code class="php">//You receive JSON
$inputJson="'message':'Success push created!','data':'YlRyencwNUU0b2NvTXFPUTl5alhheXlpZnhoTVNqZFhSVWJYd29OakpvYmFk.ajZTYjdTejdOR2Vicnp4dDN2WC51MoZQEoQAwnbw2RGb6Dvq'";

//Conver to Array
$inputArr=json_decode($inputJson,true);

$data = $inputArr['data'];
$dataArray = explode('.', $data);

//Fetch data
$clearData = $data[0];
$dataString = base64_decode($data[0]);

//Fetch signature
$serverSignature = $data[1];

//Generate your signature
$clientSignature = base64_encode(hash_hmac('sha256',$clearData,'ourPrivateKey', true));

//Check your signature with Server signature
if ($serverSignature != $clientSignature ) {
         throw new \Exception('Signature incorrect!');
}

$result = json_decode($dataString,true);
print_r($result);
/*
["req_hash"=>"someUniqCodeHash",
"answer"=>true]
*/
</code></pre>


                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="bash">...</div>
                                    <div role="tabpanel" class="tab-pane" id="cpp">...</div>
                                    <div role="tabpanel" class="tab-pane" id="java">...</div>
                                </div>

                            </div>


                        </div>





                    </div>



                </div>
            </div>
        </div>
    </section>
</div>