<div class="module-wrapper">
    <a name="encoding"></a>
<section class="module member-module module-no-heading module-no-footer">
    <div class="module-inner">
        <div class="module-heading">
            <h3 class="module-title">Encoding data algorithm</h3>


        </div>
        <div class="module-content">
            <div class="module-content-inner no-padding-bottom">
                <div class="topic-holder">

                    <div class="">

                        <div id="auth-encode-section" class="section-block">

                            After successfully registering the application in the dashboard, we have a private key available. We will use it to sign data using HMAC (SHA-256).<br>
<center>
                            <img class="img " src="{{url('assets/images/support/encoding.png')}}">
</center>
                            <h4>Actions list</h4>
                            <ol class="list">
                                <li>

                                    An encoded string consists of two string values, which are separated by a dot. (Ex: dataInBase64.hmacInBase64).
                                </li>
                                <li>

                                    To get the first part, encode your json data in BASE64.
                                </li>

                                <li>

                                    To generate the second part, create the HMAC using the value (string) from the first part with your private key and the SHA256 algorithm. For example, <code>hash_hmac('sha256', data, private_key)</code>. And the received data must be encoded in BASE64.
                                </li>

                                <li>
                                    As a result, you have two values, separated by dot.
                                </li>







                            </ol>



                        </div>


                    </div>


                    <div class="">
                        <h5  class="block-title">Code example</h5>


                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">PHP</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">BASH</a></li>
                                {{--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">C++</a></li>
                                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Java</a></li>--}}
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">


                                                <pre><code class="php">//Setting data params
$data = json_encode(['address_to'     => 'client@mysite.com',
                     'mode'           => 'push',
                     'code'           => '123-456',
                     'flash_response' => true]);

//Encode data
$encodedData = base64_encode($data);
$signature = base64_encode(hash_hmac('sha256',$encodedData,'myPrivateKey',true));

//Request data
$requestString = $encodedData. '.' .$signature;
?>
</code></pre>


                                </div>
                                <div role="tabpanel" class="tab-pane" id="profile">

<pre><code class="language-bash">#!/bin/bash

#Private Key
pass='BCTmUYdzOERpNjGIMoxGKQk0IRAArLnJ'

#Json data
encstring=$(echo -ne "{\"address_to\":\"client@yoursite.com\",\"mode\":\"push\",\"code\":\"123-456\",\"flash_response\":true}" | base64)

#Signature
hmac=$(echo "$encstring" | openssl dgst -sha256 -hex -hmac "$pass")
enchmac=$(echo -ne "$hmac" | base64)

#Request data
prestr=${encstring}.${enchmac}

</code>
    </pre>




                                </div>
                                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                                <div role="tabpanel" class="tab-pane" id="settings">...</div>
                            </div>

                        </div>


                    </div>
                </div>



            </div>
        </div>
    </div>
</section>
</div>