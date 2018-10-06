<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PushAuth\Classes\PushAuth;


//TODO  ./vendor/bin/phpunit tests/ApiPushRequest

class ApiPushRequest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function consoleLog($text)
    {
        fwrite(STDERR, $text."\n");
    }



    public function testSendPushOneClientApp()
    {

/*        $myDebugVar = array(1, 2, 3);
        fwrite(STDERR, print_r($myDebugVar, TRUE));*/


        $pub_key='AtTJPp7CJrnnIJtRTYuh6cHX8XC1RWdO';
        $priv_key='TZ52hJQuCymAIdRTg7QXD8HNofMrapAF';

        $pushRequest = new PushAuth($pub_key,$priv_key);

        $request = $pushRequest->to('info@snisar.com')
            ->mode('push')
            ->send();

        $uniqReqHash=$request;



        $pushRequestDB = \PushAuth\PushRequest::where('uniq_request_id',$uniqReqHash)->whereHas('device',function ($q){
            return $q->where('uuid', 'D7182AE6-D062-44AF-A589-DC557DFDF5FC');
        })->first();



        $device = $pushRequestDB->device;


        $devPubKey= $device->public_key;
        $devPriKey= $device->private_key;

        $devData=base64_encode('123456').'.'.base64_encode(hash_hmac('sha256',base64_encode('123456'),$devPriKey,true));

      $json = $this->json('POST','http://api.pushauth.dev/push/index',['pk'=>$devPubKey,'data'=>$devData],[]);


        $resData=json_decode($json->response->content(),true);

        $resData=explode('.',$resData['data']);
        $clearData=json_decode(base64_decode($resData[0]),true);



        $this->consoleLog(print_r($clearData,true));


if ($clearData['total'] == 1) {
    $this->assertTrue(true);
}

$this->deviceAnswerOnPush($pushRequestDB);

    }


    public function deviceAnswerOnPush($pushRequestDB)
    {

        $device = $pushRequestDB->device;


        $devPubKey= $device->public_key;
        $devPriKey= $device->private_key;




        $this->consoleLog('123');
    }




}
