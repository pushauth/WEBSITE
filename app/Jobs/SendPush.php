<?php

namespace PushAuth\Jobs;

use Log;

use PushAuth\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class SendPush extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $deviceToken, $deviceOs, $encodedData;

    /**
     * Create a new job instance.
     *
     * @param $deviceToken
     * @param $deviceOs
     * @param $encodedData
     */
    public function __construct($deviceToken, $deviceOs, $encodedData)
    {
        //
        $this->deviceToken = $deviceToken;
        $this->deviceOs = $deviceOs;
        $this->encodedData = $encodedData;
    }

    //1de13d060d3376f7c717427ac74d55b0fa0b3aede8aafb7ff0f157d54c840f65
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
/*        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(45);

        $notificationBuilder = new PayloadNotificationBuilder('PushAuth');
        $notificationBuilder->setBody('PushAuth request...')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => ['a'=>'b']]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = 'eaJSgEZgdfs:APA91bERpDt_0Zh2JL_sSplt5TicKQ8j8UMElZkvkXKGpbROZfVeAkwNCNYNejvHtlluAp5ZaW6MBzV_yHCJ9CepnrYRa7h2aU94uprp59YtLqk7cfJZ5WXy_XwZXmeMiYVnaEmOCWzc';

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);*/

/*

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60);

        $notificationBuilder = new PayloadNotificationBuilder('PushAuth');
        $notificationBuilder->setBody('PushAuth request...')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => [
            //'mode'=>'push'
            'req_hash' => '12345678901234567890123456789012',
            'mode'     => 'code',
            'code'     => '123-456',
            'app_name' => 'SomeAppNameCompany',
        ]]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = 'enVRrUIlaew:APA91bG2JXiUH2UPaEc7hDI8BKU32HI4AFKY0E8m5MclbmyiSy93EeEHLOJs73URue2galxBO7qLauDfayKMTxMaQmgR7oQgYBbiP1UV8uidNkixGKG1w25fMmkNFuL8-01IKsr0awHp';

        Log::info('START SEND PUSH');

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        Log::info('PUSH SENDED');



        Log::info('NumberSuccess: '. print_r($downstreamResponse->numberSuccess(),true));
        Log::info('NumberFailure: '. print_r($downstreamResponse->numberFailure(),true));
        Log::info('NumberModification: '. print_r($downstreamResponse->numberModification(),true));


        Log::info('tokensToDelete: '. print_r($downstreamResponse->tokensToDelete(),true));

        Log::info('tokensToModify: '. print_r($downstreamResponse->tokensToModify(),true));

        Log::info('tokensToRetry: '. print_r($downstreamResponse->tokensToRetry(),true));

        Log::info('PUSH STOPED');*/


        /*//return Array - you must remove all this tokens in your database
                $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
                $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
                $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:errror) - in production you should remove from your database the tokens

        */



        if (array_key_exists('app_name', $this->encodedData)) {
            $appName = $this->encodedData['app_name'];
        } else {
            $appName = 'PushAuth';
        }





        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(45);

        $notificationBuilder = new PayloadNotificationBuilder('PushAuth service');
        $notificationBuilder->setBody($appName.' send authorization request.')
            ->setSound('default');




        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($this->encodedData);

        //$dataBuilder->addData(['a_data' => $this->encodedData]);




        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $this->deviceToken;

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

/*        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();*/

/*//return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

//return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

//return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the tokens







/*

        if ($this->deviceOs == 'ios') {


            $devices = PushNotification::DeviceCollection([
                PushNotification::Device($this->deviceToken)
            ]);


            $message = PushNotification::Message('Message Text',[
                'custom' => ['push_data'=>$this->encodedData]
            ]);

             $adapter = PushNotification::app(['environment' => 'development',
                                   'certificate' => storage_path('/certs/APN.pem'),
                                   'passPhrase'  => 'password',
                                   'service'     => 'apns'])
                ->to($devices)
                ->send($message);





        }
        elseif ($this->deviceOs == 'android') {
            $push = PushNotification::app(['environment' => 'production',
                                           'apiKey'      => 'yourAPIKey',
                                           'service'     => 'gcm']);
            $push->adapter->setAdapterParameters(['time_to_live' => 60]);
            $push->to($this->deviceToken)->send('New PushAuth!',[
                'data' => $this->encodedData
            ]);
        }
*/



    }
}
