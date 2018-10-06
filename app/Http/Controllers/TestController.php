<?php

namespace PushAuth\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Http\Client\Exception\RequestException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Log;
use Mail;
use Mailgun;
use PushAuth\Classes\SomeClass;

use PushAuth\Http\Requests;
use PushAuth\Http\Controllers\Controller;
use PushAuth\Classes\PushAuth;
use PushAuth\Jobs\SendPush;
use PushAuth\Jobs\WebHook;
use PushAuth\PushRequest;
use PushAuth\PushRoutes;
use PushAuth\User;
use PushAuth\UserMsgLog;
use Redis;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Invoice;
use Stripe\Stripe;
use Validator;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeStripe(Request $request)
    {

        //dd($request->all());
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $cu = Customer::retrieve('cus_AwEjjTyvrWJP0V'); // stored in your application
            $cu->sources->create(array("source" => $request->stripeToken));

            dd($cu->sources);

            $success = "Your card details have been updated!";
        }
        catch(Card $e) {

            // Use the variable $error to save any errors
            // To be displayed to the customer later in the page
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $error = $err['message'];
        }

        dd($request->all());
    }
    public function showCookie()
    {
        return response('Cookie set!')->withCookie(cookie('name', 'my value', 1));
    }


    public function showStripe()
    {
        $user=Auth::user();
        dd($user->stripeCards()->count());


        $json2="{
  \"id\": \"in_1AbR4FGMdpFXXBZfKQIGzTm6\",
  \"object\": \"invoice\",
  \"amount_due\": 1000,
  \"application_fee\": null,
  \"attempt_count\": 1,
  \"attempted\": true,
  \"charge\": \"ch_1AbR5fGMdpFXXBZfY4zf0quY\",
  \"closed\": false,
  \"currency\": \"usd\",
  \"customer\": \"cus_AwxWiOTIJQ0Pam\",
  \"date\": 1499074927,
  \"description\": null,
  \"discount\": null,
  \"ending_balance\": 0,
  \"forgiven\": false,
  \"lines\": {
    \"data\": [
      {
        \"id\": \"sub_Ax4AFlq4Aua48Z\",
        \"object\": \"line_item\",
        \"amount\": 0,
        \"currency\": \"usd\",
        \"description\": null,
        \"discountable\": true,
        \"livemode\": true,
        \"metadata\": {
        },
        \"period\": {
          \"start\": 1499009471,
          \"end\": 1499095871
        },
        \"plan\": {
          \"id\": \"2\",
          \"object\": \"plan\",
          \"amount\": 100,
          \"created\": 1498815055,
          \"currency\": \"usd\",
          \"interval\": \"month\",
          \"interval_count\": 1,
          \"livemode\": false,
          \"metadata\": {
          },
          \"name\": \"PREMIUM\",
          \"statement_descriptor\": \"PREMIUM\",
          \"trial_period_days\": null
        },
        \"proration\": false,
        \"quantity\": 1,
        \"subscription\": null,
        \"subscription_item\": \"si_1AbA2VGMdpFXXBZfAIUrmx99\",
        \"type\": \"subscription\"
      }
    ],
    \"total_count\": 1,
    \"object\": \"list\",
    \"url\": \"/v1/invoices/in_1AbR4FGMdpFXXBZfKQIGzTm6/lines\"
  },
  \"livemode\": false,
  \"metadata\": {
  },
  \"next_payment_attempt\": 1499334151,
  \"paid\": false,
  \"period_end\": 1499074927,
  \"period_start\": 1499009471,
  \"receipt_number\": null,
  \"starting_balance\": 0,
  \"statement_descriptor\": null,
  \"subscription\": null,
  \"subtotal\": 1000,
  \"tax\": null,
  \"tax_percent\": null,
  \"total\": 1000,
  \"webhooks_delivered_at\": 1499074927
}";
        $arr=json_decode($json2,true);

        /*
         * $arr['id'];
         * $arr['customer']
         * $arr['paid']
         * $arr['currency']
         * $arr['total']
         * $arr['lines']['data'][0]['period']['start']
         * $arr['lines']['data'][0]['period']['end']
         */

        //dd($arr['lines']['data'][0]['period']['start']);



        $user = \Auth::user();

        Stripe::setApiKey(env('STRIPE_SECRET'));










        try {
            $cu = Customer::retrieve('cus_AwxWiOTIJQ0Pam'); // stored in your application
            // Set the new card as the customers default card
            $invoice = Invoice::retrieve("in_1AbR4FGMdpFXXBZfKQIGzTm6");
            $invoice = $invoice->pay();

/*
            $cards=$cu->sources->all(array("object" => "card"));
            $cards=$cu->default_source;

            $cards = $cards;*/

            //$cu->sources->create(array("source" => $request->stripeToken));

            //$cu->subscriptions->


            $success = "Your credit card have been added!";
        }
        catch (InvalidRequest $e) {

        }
        catch(Card $e) {



        }
        //$invoice = $invoice->__toArray(true);

        //$invoice['paid'];
        dd($invoice);



$json="{
  \"id\": \"evt_1Ab5PtGMdpFXXBZfxSCYCL3J\",
  \"object\": \"event\",
  \"api_version\": \"2017-02-14\",
  \"created\": 1498991701,
  \"data\": {
    \"object\": {
      \"id\": \"in_1Ab5PtGMdpFXXBZfhwiMSFLD\",
      \"object\": \"invoice\",
      \"amount_due\": 100,
      \"application_fee\": null,
      \"attempt_count\": 0,
      \"attempted\": true,
      \"charge\": \"ch_1Ab5PtGMdpFXXBZfgz8PmExs\",
      \"closed\": true,
      \"currency\": \"usd\",
      \"customer\": \"cus_AwxWiOTIJQ0Pam\",
      \"date\": 1498991701,
      \"description\": null,
      \"discount\": null,
      \"ending_balance\": 0,
      \"forgiven\": false,
      \"lines\": {
        \"object\": \"list\",
        \"data\": [
          {
            \"id\": \"sub_AwzOyAH1QCK1Fz\",
            \"object\": \"line_item\",
            \"amount\": 100,
            \"currency\": \"usd\",
            \"description\": null,
            \"discountable\": true,
            \"livemode\": false,
            \"metadata\": {
            },
            \"period\": {
              \"start\": 1498991701,
              \"end\": 1501670101
            },
            \"plan\": {
              \"id\": \"2\",
              \"object\": \"plan\",
              \"amount\": 100,
              \"created\": 1498815055,
              \"currency\": \"usd\",
              \"interval\": \"month\",
              \"interval_count\": 1,
              \"livemode\": false,
              \"metadata\": {
              },
              \"name\": \"PREMIUM\",
              \"statement_descriptor\": \"PREMIUM\",
              \"trial_period_days\": null
            },
            \"proration\": false,
            \"quantity\": 1,
            \"subscription\": null,
            \"subscription_item\": \"si_1Ab5PtGMdpFXXBZfRTcKlMtm\",
            \"type\": \"subscription\"
          }
        ],
        \"has_more\": false,
        \"total_count\": 1,
        \"url\": \"/v1/invoices/in_1Ab5PtGMdpFXXBZfhwiMSFLD/lines\"
      },
      \"livemode\": false,
      \"metadata\": {
      },
      \"next_payment_attempt\": null,
      \"paid\": false,
      \"period_end\": 1498991701,
      \"period_start\": 1498991701,
      \"receipt_number\": null,
      \"starting_balance\": 0,
      \"statement_descriptor\": null,
      \"subscription\": \"sub_AwzOyAH1QCK1Fz\",
      \"subtotal\": 100,
      \"tax\": null,
      \"tax_percent\": null,
      \"total\": 100,
      \"webhooks_delivered_at\": null
    }
  },
  \"livemode\": false,
  \"next_payment_attempt\": null,
  \"pending_webhooks\": 1,
  \"request\": \"req_AwzO424ZKUDkc8\",
  \"type\": \"invoice.payment_succeeded\"
}";
        $user->plan()->update([
            'plan_id'=>'1'
        ]);
        $v=json_decode($json,true);

        dd($v['next_payment_attempt']);
        dd(Carbon::createFromTimeStampUTC($v['data']['object']['period_end'])->toDateTimeString());




        if ($user->stripe == false){
            dd('false');
        }else {
            dd('true');
        }
/*        Stripe::setApiKey('sk_test_rQmHc3PdEq7QqvRTiRDK9JT6');

        $customer = Customer::create(array(
            "email" => "info@snisar.com",
        ));
        dd($customer->id);*/



        return view('tester.stripe');

    }
    public function showGuzzle()
    {

        $client = new Client();



        try {
            $response = $client->request('POST', 'http://pushauth.dev/tester/http', []);
            $statusCode=$response->getStatusCode();
        }

        catch (ConnectException $e) {

            return false;


        } catch (RequestException $e) {

           return false;

        } catch (ClientException $e) {
            $statusCode=$e->getCode();

        } catch (ServerException $e) {
            $statusCode=$e->getCode();
        }

        //$statusCode=$response->getStatusCode();
        dd($statusCode);



    }

    public function showValidator() {
$json="eyJyZXFfaGFzaCI6Img5ZlljSXZCbVVid25zYWliWHh5dXVUcDgxS2RnV2hxIiwiYXBwX3B1YmxpY19rZXkiOiJ0bXVrZWdncERnNTFkQ2liREJWZE9tV1BLcnNXZzVaWSIsImFwcF9uYW1lIjoiVGVzdEFwcCIsImNsaWVudF9lbWFpbCI6ImluZm81QHNuaXNhci5jb20iLCJjbGllbnRfcGxhdGZvcm0iOiJpb3MiLCJhbnN3ZXIiOiJmYWxzZSIsInJlc3BvbnNlX3RpbWVzdGFtcCI6MTQ5OTE1MjY5OX0=";
        dd(base64_decode($json,true));



    }


    public function showPushAuth() {

/*        $ans=null;

        dd(filter_var($ans, FILTER_VALIDATE_BOOLEAN));*/


        $pushRequest = new PushAuth('tmukeggpDg51dCibDBVdOmWPKrsWg5ZY', 'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza');

        try {
            $request = $pushRequest->to([
                ['1'=>'info5@snisar.com']
            ])
                ->code('123-456')
                ->mode('code')
                ->response(false)
                ->send();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }



dd($request);

dd($pushRequest->requestStatus('H6Jx9CVAyGgyPMjeFF8gw9PEkeFISmBK'));

/*        $v=[
            ['1'=>'info1@zenlix.com'],
            ['5'=>'info2@zenlix.com'],
            ['5'=>'info3@zenlix.com']
        ];
        $na=[];

        foreach ($v as $vv) {
            foreach ($vv as $k=>$kk) {
                array_push($na,[
                    'order'=>$k,
                    'address'=>$kk
                ]);
            }


        }

        dd(collect($na)->groupBy('order')->count());*/

        //array_unique($v);

       // dd(array_unique($v));



/*        $v=[
            ['5'=>'info@zenlix.com'],
            ['1'=>'info@zenlix.com'],
            ['5'=>'info@zenlix.com']
        ];



        $na=[];

foreach ($v as $vv) {
    foreach ($vv as $k=>$kk) {
        array_push($na,[
            'order'=>$k,
            'address'=>$kk
        ]);
    }


}

        usort($na, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        $adrs=[];
        foreach ($na as $nav) {
            array_push($adrs,$nav['address']);



        }



        dd(array_shift($adrs));*/


        $pushRequest = new PushAuth('tmukeggpDg51dCibDBVdOmWPKrsWg5ZY', 'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza');





        $request = $pushRequest->to([
            ['1'=>'info5@snisar.com'],
            ['2'=>'info6@snisar.com']])
            ->send();

        dd($request);




    }

    public function showCarbon() {
        $m = UserMsgLog::where('user_id', '1')
            ->where('msg_pushlimit_dt', '>=', Carbon::now()
                ->subDay())->exists();
        dd($m);

    }



    public function showHmac2() {

$b = base64_encode('{"req_hash":"someUniqCodeHash","answer":false}');
//echo $b.".".base64_encode(hash_hmac('sha256',$b,'eyJhZGRyZXNzX3RvIjp7JzEnOidjbGll',true));

dd($b.".".base64_encode(hash_hmac('sha256',$b,'eyJhZGRyZXNzX3RvIjp7JzEnOidjbGll',true)));
        $t = new SomeClass();

        $m=$t->to('aaa')->send();
        $z=$t->to('bbb')->send();

        dd($m);
        //dd('m:'.$m->d.' z:'.$z.' m:'.$m);


        $data = json_encode(['address_to'     => 'client@mysite.com',
                             'mode'           => 'push'
        ]);

//Try encode data
        $encodedData = base64_encode($data);
        $signature = base64_encode(hash_hmac('sha256',$encodedData,'myPrivateKey',true));

//Encoded data
        $requestString = $encodedData. '.' .$signature;


        dd($requestString);
        $str='OD1ztbg5JpX2jpQdpgr3GvOfYzD6T6zG';
        //dd($str);

        $key='OD1ztbg5JpX2jpQdpgr3GvOfYzD6T6zG';

        dd(base64_encode(hash_hmac('sha256', base64_encode($str), $key,true)));

    }

    public function showRedisStore() {

        Redis::publish('PushAuthChanel', json_encode([
            'msgType' => 'webPush',
            'public_key' => '12345678901234567890123456789012',
            'socketid'=>'U2Opu4Wz4bXC_8AXAAAA',
            'title' => 'title',
            'message' => 'mess',
            'url' => 'url',

        ]));
        dd('ok');
    }



    public function showRedis() {
        //dd('ok');


        //$c='';
     Redis::subscribe(['PushAuthChanel'], function($message) {

            Redis::unsubscribe(['PushAuthChanel']);


        });



        return response()->json('ff', 200);


        dd('ok');

        Redis::publish('PushAuthChanel', json_encode([
            'msgType' => 'webPush',
            'public_key' => '12345678901234567890123456789012',
            'socketid'=>'U2Opu4Wz4bXC_8AXAAAA',
            'title' => 'title',
            'message' => 'mess',
            'url' => 'url',

        ]));

    }

    public function showMailgun() {

/*
 * qr_login_the_key=eyJpdiI6InliWWwxY1o2Ym1kaGc5T1wvbFh2Y1pBPT0iLCJ2YWx1ZSI6IkJrRG1Za2tuY3pUVEIxOTdaTjBxbnJ5K1Jub1l6RUVOVWdYd01HWUxnRXk1NEpjNFwvakYwc3dKQzBsQVwvdDJnOSIsIm1hYyI6IjVmOWUyMzRiOTY4NzQwN2MwY2QwOTM3Yjc5MmVkYjRjMDg5MGM1OGI1OWZjN2I2OGFjM2M2ZDAyMTU0YmM5ZDAifQ%3D%3D; laravel_session=eyJpdiI6Ikh6NnlLUlVCS3EzaVdMUVwvZkVBUGdnPT0iLCJ2YWx1ZSI6ImZINUl5c3ZNanlia3MybXcxaVB4TThOdjl0UVgrWUM1cVl6OWdHRnZuY0E2NDVcL2U0aFRPYmpYdXlFVE9QZyt5UmlPdTNkZE1ZRHZRUXk2azJKdmpDZz09IiwibWFjIjoiMjhjNzBiYjA2N2JiMjg4NWMyNDUwMzU3MGJlZDgwMmFkZDI2ZTdkMTg2MGI4ZmFhMGIxOTBmMzk5OTEzOWNlNSJ9
 *
 *
        $v = Mailgun::validator()->validate("info.rs@snisar.com");
        dd($v);
        {#356 ▼
            +"address": "info2@snisar.co"
        +"did_you_mean": null
        +"is_disposable_address": false
        +"is_role_address": false
        +"is_valid": false
        +"parts": {#359 ▼
            +"display_name": null
            +"domain": null
            +"local_part": null
  }
}

        dd('stop');

        */
        $dataMail = [
            'url'=>route('confirmation','test')
        ];

        Mail::queue(['text' => 'emails.confirmation.device'], $dataMail, function ($message) {
            $message->from('support-reply@mg.pushauth.io', 'PushAuth');
            $message->subject('PushAuth Confirmation Device');
            $message->to('info@snisar.com');
        });



    }

    public function showModel() {


/*$req = new PushAuth('');
$req->mode('code')->code('123')->flashResponse('true');
$req->isAccept()*/

        $nextPushRoute = PushRoutes::where('req_id','203')
            ->where('status','wait')
            ->orderBy('order','asc')
            ->get();

        $pushRequest=PushRequest::find(203);

        $clientsArr = $pushRequest->routes->unique('client_id')->lists('client_id')->toArray();


        dd($clientsArr);





        $user=User::where('email', 'info@snisar.com')->first();

        $limits = $user->plan->limits;


        dd($limits->where('key','pushes')->first()->value);




        $device = $user->devices()->where('uuid', 'myuuid1')->first();

        $device->update(['uuid'=>'myuuid']);


        dd($device->uuid);

    }


    public function showFirebase() {






        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(30);

        $notificationBuilder = new PayloadNotificationBuilder('PushAuth');
        $notificationBuilder->setBody('PushAuth request...')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'req_hash' => '12345678901234567890123456789012',
            'mode'     => 'code',
            'code'     => '123-456',
            'app_name' => 'SomeAppNameCompany',

        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = 'cdn6FGF3oN0:APA91bEdPYrYYgwPZQ1tPiJappHQUL4iiV5dOvvViqqiodO6eY_9zVXpg4GK25fINsuJaSpaQGidAr5mGRwj39zLAE_9i7425XlQB9T1F-fiCHOGrO07Vv5bN7FRpcVP6zj0Q3oIQ8Fp';

        Log::info('START SEND PUSH');

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        Log::info('PUSH SENDED');



        Log::info('NumberSuccess: '. print_r($downstreamResponse->numberSuccess(),true));
        Log::info('NumberFailure: '. print_r($downstreamResponse->numberFailure(),true));
        Log::info('NumberModification: '. print_r($downstreamResponse->numberModification(),true));


        Log::info('tokensToDelete: '. print_r($downstreamResponse->tokensToDelete(),true));

        Log::info('tokensToModify: '. print_r($downstreamResponse->tokensToModify(),true));

        Log::info('tokensToRetry: '. print_r($downstreamResponse->tokensToRetry(),true));

        Log::info('PUSH STOPED');





    }


    public function indexSend($id)
    {
        Redis::set($id, 'true');
        Redis::expire($id, 30);
    }

    public function showPush() {

/*
        $push = PushNotification::app(['environment' => 'development',
                                       'certificate' => storage_path('/certs/APN.pem'),
                                       'passPhrase'  => 'password',
                                       'service'     => 'apns']);
        //$push->adapter->setAdapterParameters(['time_to_live' => 60]);
        $push->to('303f7d008d43ac8bd944bbac89bcefda400b7df37d677614ba01e5ca03cc48aa')->send('New PushAuth!',[
            'data' => 'rrr'
        ]);
*/

        $devices = PushNotification::DeviceCollection([
            PushNotification::Device('303f7d008d43ac8bd944bbac89bcefda400b7df37d677614ba01e5ca03cc48aa')
        ]);


        $message = PushNotification::Message('Message Text',[
            'custom' => ['push_data'=>[
                'a'=>'b'
            ]]
            ]);

        PushNotification::app(['environment' => 'development',
                               'certificate' => storage_path('/certs/APN.pem'),
                               'passPhrase'  => 'password',
                               'service'     => 'apns'])
            ->to($devices)
            ->send($message);


    }


    function aesEncrypt($data, $key) {
        $data = addPadding($data);
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $cipherText = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);
        $result = base64_encode($iv.$cipherText);
        return $result;
    }
    function aesDecrypt($base64encodedCipherText, $key) {
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $cipherText = base64_decode($base64encodedCipherText);
        if (strlen($cipherText) < $ivSize) {
            throw new Exception('Missing initialization vector');
        }
        $iv = substr($cipherText, 0, $ivSize);
        $cipherText = substr($cipherText, $ivSize);

        $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $cipherText, MCRYPT_MODE_CBC, $iv);
        $result = $this->stripPadding(rtrim($result, chr(0x0b)));
        return $result;
    }
    function addPadding($value){
        $pad = 16 - (strlen($value) % 16);
        return $value.str_repeat(chr($pad), $pad);
    }

    function stripPadding($value){
        $pad = ord($value[($len = strlen($value)) - 1]);
        return $this->paddingIsValid($pad, $value) ? substr($value, 0, $len - $pad) : $value;
    }

    function paddingIsValid($pad, $value){
        $beforePad = strlen($value) - $pad;
        return substr($value, $beforePad) == str_repeat(substr($value, -1), $pad);
    }



    function strToHex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }
    function hexToStr($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
    public function showHmac() {


dd(base64_decode("eyJhZGRyZXNzX3RvIjoiaW5mbzEwQHNuaXNhci5jb20iLCJjb2RlIjoiIiwiZmxhc2hfcmVzcG9uc2UiOmZhbHNlLCJtb2RlIjoicHVzaCJ9"));
//C++
//  JSON: {"req_hash":"someUniqCodeHash","answer":true}
//  BASE64: eyJyZXFfaGFzaCI6InNvbWVVbmlxQ29kZUhhc2giLCJhbnN3ZXIiOnRydWV9
//  HMAC: P/p2YlxL8xdhmn+QIAlVLFDS50ai4JE/l1pMMrKZKrE=
// 
//
//  JSON: {"req_hash":"someUniqCodeHash","answer":false}
//  BASE64: eyJyZXFfaGFzaCI6InNvbWVVbmlxQ29kZUhhc2giLCJhbnN3ZXIiOmZhbHNlfQ==
//  HMAC: znUOWS2MMLpjIBSpq2GfSNivaL8IUDcZXZs24D0=
//  



//PHP
//  JSON: {"req_hash":"someUniqCodeHash","answer":true}
//  BASE64: eyJyZXFfaGFzaCI6InNvbWVVbmlxQ29kZUhhc2giLCJhbnN3ZXIiOnRydWV9
//  HMAC: P/p2YlxL8xdhmn+QIAlVLFDS50ai4JE/l1pMMrKZKrE=
//  
//  JSON: {"req_hash":"someUniqCodeHash","answer":false}
//  BASE64: eyJyZXFfaGFzaCI6InNvbWVVbmlxQ29kZUhhc2giLCJhbnN3ZXIiOmZhbHNlfQ==
//  HMAC: znUOWS2MMLpjIBSpq2GfSNivaL8IUDcZXZs24D0AHZA=


//eyJhZGRyZXNzX3RvIjoiaW5mbzEwQHNuaXNhci5jb20iLCJjb2RlIjoiIiwiZmxhc2hfcmVzcG9uc2UiOmZhbHNlLCJtb2RlIjoicHVzaCJ9.zWNxJ6QBwYuA/J2xXRZ7hkwt9+5mhAFbNPpQLosoRS0=
//zWNxJ6QBwYuA/J2xXRZ7hkwt9+5mhAFbNPpQLosoRS0=
//zWNxJ6QBwYuA/J2xXRZ7hkwt9+5mhAFbNPpQLosoRS0=
$arr = [
'req_hash'=>'someUniqCodeHash',
'answer'=>false
];


$b = base64_encode("");
//dd($b);
//
//ce75e592d8c30ba
//ce750e592d8c30ba632014a9ab619f48d8af68bf085037195d9b36e03d001d90
//ce75e 592d8c30ba632014a9ab619f48d8af68bf 85037195d9b36e03d

//echo $b.".".base64_encode(hash_hmac('sha256',$b,'eyJhZGRyZXNzX3RvIjp7JzEnOidjbGll',true));

dd(base64_encode(hash_hmac('sha256','eyJhZGRyZXNzX3RvIjoiaW5mbzEwQHNuaXNhci5jb20iLCJjb2RlIjoiIiwiZmxhc2hfcmVzcG9uc2UiOmZhbHNlLCJtb2RlIjoicHVzaCJ9','iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza',true)));
}



    public function indexCpp(Request $request)
    {

        Log::info(print_r($request->all(),true));

$b = base64_encode("{\"req_hash\":\"someUniqCodeHash\",\"answer\":false}");


        return response()->json([
'data'=>$b.".".base64_encode(hash_hmac('sha256',$b,'iCD90UOsz0VxX5JOFRm1LdiPTrqOOvza',true))
        ], 200);

    }

    public function indexHttp(Request $request)
    {

        return response()->json([], 200);

        Log::alert('WebHOOK headers: '. $request->headers);
        Log::alert('WebHOOK ctype: '. $request->getContentType());
        Log::alert('WebHOOK data: '. print_r($request->all(),true));
    }


    public function index(Request $request)
    {

        dd(base64_decode('eyJhcHBfcHVibGljX2tleSI6IlVVWHVva01Ja1JCbmFiQTJtajkxMXRBNXVtUzhQTVBoIiwiYXBwX25hbWUiOiJUZXN0QXBwIiwiY2xpZW50X2VtYWlsIjoiaW5mb0BzbmlzYXIuY29tIiwiY2xpZW50X3BsYXRmb3JtIjoiaW9zIiwicmVzcG9uc2VfdGltZXN0YW1wIjoxNDk2MDQ2NTAzfQ=='));


$data = base64_encode(json_encode([
    'hash'=>'o7QZiWuPCgusFNBZsFrvA78zG6AymX8N'
]));
        $hmac = base64_encode(hash_hmac('sha256',$data,'12345678901234567890123456789012', true));

        dd($data.'.'.$hmac);

        $pushRequest = new PushAuth('UUXuokMIkRBnabA2mj911tA5umS8PMPh','w4hcC97wXtGzqXGizSOgS9u40cdry7cF');

        $request = $pushRequest->qrconfig([
            'margin'=>'5',
            'size'=>'256',
            'color'=>'121,0,121'
        ])->qr();

        /*
        $request = $pushRequest->to('info@snisar.com')
            ->mode('push')
            //->code('123-456')
            //->response(true)
            ->send();*/

        dd($request);








        dd('');
        $public_key = 'UUXuokMIkRBnabA2mj911tA5umS8PMPh';
        $private_key = 'w4hcC97wXtGzqXGizSOgS9u40cdry7cF';

        dd(base64_decode('eyJhcHBfcHVibGljX2tleSI6IlVVWHVva01Ja1JCbmFiQTJtajkxMXRBNXVtUzhQTVBoIiwiYXBwX25hbWUiOiJUZXN0QXBwIn0='));




        dd('stop');
        $pushRequest = PushRequest::find(2);

        dd($pushRequest->created_at->timestamp);

        $job = (new WebHook($pushRequest,'timeout'));


        $this->dispatch($job);


        dd('stop');

        Log::alert('WebHOOK headers: '. $request->headers);
        Log::alert('WebHOOK ctype: '. $request->getContentType());
        Log::alert('WebHOOK data: '. print_r($request->all(),true));
        dd('stop');





        Log::alert('WebHOOK STARTED AT: '. Carbon::now()->toDateTimeString());

        $job = (new WebHook())->delay(60);
        $this->dispatch($job);
        dd('stop');
/*        $pub='12345678901234567890123456789012';
        $pri='12345678901234567890123456789012';

$data=base64_encode(json_encode(['hash'=>'oRdWD47rTfNq5E2WNEMah4UXkozamCME']));
        $sign = base64_encode(hash_hmac('sha256', $data, $pri, true));
dd($data.'.'.$sign);*/


        $pushRequest = new PushAuth('WY3t2CE8Hv9lwOCdQT9BKzuMXXzHuF7V','UM2KnvDel6hyTgmh31Y0mxXWAvziO9qd');
        $req = $pushRequest->qrconfig([
            'margin'=>'5',
            'size'=>'256',
            'color'=>'121,0,121'
        ])->qr();
        dd($req);





/*        Redis::set('V9UTpwD26dFE7gcLUJh3w8CTADqJOq4G', 'true');
        Redis::expire('V9UTpwD26dFE7gcLUJh3w8CTADqJOq4G', 30);

        dd('');*/




        //Send Push request to your client device
/*        $request = $pushRequest->to('info@zenlix.com')
            ->mode('push')
            ->code('123-456')
            ->response(true)
            ->send();

        dd($request);*/


        //dd($pushRequest->requestStatus('91owhpevET27r4oHOX3slk5vspP9qSDS'));
        //return answer
//show request hash
       // print_r($request);
// will return Request Hash

//show your client answer
        //dd($request->isAccept());
// will return true/false or null if answer not received

//Show push request information
        dd($pushRequest->isAccept());
        /*
        will return array:
        ['answer'=>true,
        'response_dt'=>'Time....',
        'response_code'=>200,
        'response_message'=>'Success answer received']
        */

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testEncrypt(Request $request)
    {

        dd(request()->ip());
        //
       // $str = base64_decode('4+1rS33uqexbBprsPCvRGg==');

        //dd($str);
        $result = openssl_decrypt('ipWd1K2T6e9P+FjJ16/EaFAU8tKR f37QsouujisGaeJt4h+ukJoJCgcSJkECXgpL5bXYAcD9 mEViElviT86SQwvR3QU8/YwqZKDaBm6SY8waD78Z V+n8S97e63ZnQ1R6', 'aes-256-cbc', 'BCTmUYdzOERpNjGIMoxGKQk0IRAArLnJ', 0, '1234567890123456');
        //$result = openssl_encrypt('{"address_to":"client@yoursite.com","mode":"push","code":"123-456","flash_response":true}', 'aes-256-cbc', 'BCTmUYdzOERpNjGIMoxGKQk0IRAArLnJ', 0, '1234567890123456');
        //openssl_decrypt()
        //openssl_encrypt()

        dd($result);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //

        $data = 'eyJtb2RlIjoicHVzaCIsImNvZGUiOiIxMjMiLCJmbGFzaF9yZXNwb25zZSI6dHJ1ZSwiYWRkcl90byI6ImluZm9AemVubGl4LmNvbSJ9.VU5aZXllTzlFUldMaHEwRWkrQVpzUC9ITTFKTE8yUU82RElyZUpLWU8xMD0=';
        //GUkoLkWbDGSGBiIlWevVwjjMXFcxbCBiJjGxPfPmeqA=

        $dataArr = explode('.',$data);

        //dd(json_decode(base64_decode($dataArr[0]), true));

dd(base64_encode(hash_hmac('sha256', 'eyJtb2RlIjoicHVzaCIsImNvZGUiOiIxMjMiLCJmbGFzaF9yZXNwb25zZSI6dHJ1ZSwiYWRkcl90byI6ImluZm9AemVubGl4LmNvbSJ9', '12345678901234567890123456789012', true)));



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
