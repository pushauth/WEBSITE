<div class="module-wrapper">
    <a name="php"></a>
    <section class="module member-module module-no-heading module-no-footer">
        <div class="module-inner">
            <div class="module-heading">
                <h3 class="module-title">PHP</h3>


            </div>
            <div class="module-content">
                <div class="module-content-inner no-padding-bottom">
                    <div class="topic-holder">

                        <h3>Requirements</h3>
                        <p>PHP 5.6 and later.</p>

                        <h3>Composer</h3>
<p>You can install the bindings via Composer. Run the following command:<br>
                        <pre><code class="shell">composer require pushauth/pushauth-php</code></pre></p>


    <p>To use the bindings, use Composer's autoload:<br>
        <pre><code>require_once('vendor/autoload.php');</code></pre></p>

<h3>Manual Installation</h3>
<p>If you do not wish to use Composer, you can download the latest release. Then, to use the bindings, include the init.php file.

                       <pre><code> require_once('/path/to/pushauth-php/pushahuth.php');</code></pre>
                        </p>

                        <h3>Dependencies</h3>

                        <p>The bindings require the following extension in order to work properly:
<ul>
                            <li>curl, although you can use your own non-cURL client if you prefer</li>
                            <li>json</li>
                            <li>mbstring (Multibyte String)</li>
                        </ul>



                            </p>
                        <p>
                        If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.</p>


                        <h3>Getting Started</h3>
<p>Simple usage looks like:

<pre><code>use PushAuth\PushAuth;

//Setting your Public & Private keys
$authRequest = new PushAuth('publicKey', 'privateKey');</code></pre>
</p>

                        <h3>Sending Push Request</h3>
                        <p>And waiting responce from client until 30 sec:

                        <pre><code>$request = $authRequest->to('client@yourfirm.com')
                       ->mode('push')
                       ->response(false)
                       ->send();

if ($authRequest->isAccept()) {
                                //Make logIn action...
                            } else {
                                //Make Access Denied action...
                            }</code></pre>
                        </p>
                        <p><br><br>
                            Or custom wait 10 seconds response with self check:
                        <pre><code>$request = $authRequest->to('client@yourfirm.com')
                       ->mode('push')
                       ->response(true)
                       ->send();

$sec = 1;
while ($sec <= 10) {
 if ($authRequest->isAccept()) { //Make LogIn action }
$sec++;
sleep(1);
}

if ($authRequest->isAccept() == false) { //Make Access Denied action }
if ($authRequest->isAccept() == Null) { //No answer from client }  </code></pre>
                        </p>



                        <h3>Sending Push Code</h3>
                        <p>Special security code to client device:

                        <pre><code>$request = $authRequest->to('client@yourfirm.com')
                       ->mode('code')
                       ->code('123-456')
                       ->send();</code></pre>
                        </p>


                        <h3>Sending Routing Push Request</h3>
                        <p>To all clients together and wait response:

                        <pre><code>$request = $authRequest->to([
                                ['1'=>'client.one@yourfirm.com'],
                                ['1'=>'client.two@yourfirm.com'],
                                ['1'=>'client.three@yourfirm.com']
                                ])
                                ->response(false)
                                ->send();</code></pre>
                        All clients recieve push and request will be true only if all clients answering true.
                        </p>
                        <p>
                            <br><br>
                            To all clients by order:

                        <pre><code>$request = $authRequest->to([
                                ['1'=>'client.one@yourfirm.com'],
                                ['2'=>'client.two@yourfirm.com'],
                                ['3'=>'client.three@yourfirm.com']
                                ])
                       ->send();

if ($authRequest->isAccept()) { //Make LogIn action }
if ($authRequest->isAccept() == false) { //Make Access Denied action }
if ($authRequest->isAccept() == Null) { //No answer from client }
                            </code></pre>
                        The first client receive push and the next client will receive push only if previous answer true. All request will be true, only if all clients answered true.
                        </p>

                        <h3>Retrieve request status</h3>
                        <p>At any time you can view request status:

                        <pre><code>$request = $authRequest->to('client@yourfirm.com')
                       ->mode('push')
                       ->send();

//show request hash
print_r($request);
// will return Request Hash ex. 1232dwfef31x4xfcf34c2x4

//Show push request information
print_r($authRequest->requestStatus($request));
/*
will return array:
['answer'=>true,
'response_dt'=>'Time....',
'response_code'=>200,
'response_message'=>'Success answer received']
*/</code></pre>


                        </p>


                        <h3>Show QR-code</h3>
                        <p>Generate QR-code for client reading and auth:

                        <pre><code>$qr_url = $authRequest->qrconfig([
            'margin'=>'5',
            'size'=>'256',
            'color'=>'121,0,121'
        ])->qr();

if ($authRequest->isAccept()) { //Make LogIn action }
if ($authRequest->isAccept() == false) { //Make Access Denied action }
if ($authRequest->isAccept() == Null) { //No answer from client }

                            </code></pre>
                        </p>



<h3>Documentation</h3>

<p>Please see: https://dashboard.pushauth.io/support/api</p>

                        <h3>Support</h3>

                        <p>Please see: {{route('support.ticket.create')}}</p>



                </div>



                </div>
            </div>
        </div>
    </section>
</div>