<?php

namespace PushAuth\Jobs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Log;
use PushAuth\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use PushAuth\PushRequest;
use PushAuth\PushRoutes;

class WebHook extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $uniqRequestID, $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uniqRequestID, $type)
    {
        //
        $this->uniqRequestID = $uniqRequestID;
        $this->type = $type;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $pushRequest = PushRequest::where('uniq_request_id', $this->uniqRequestID)->first();

        $webHook = $pushRequest->app->hook;

        $app = $pushRequest->app;


        if ($app->user->status == 'disable') {
            return false;
        }
        if ($app->status == 'disable') {
            return false;
        }
        if ($webHook->status == 'disable') {
            return false;
        }
        if (filter_var($webHook->payload_url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }




        if (($this->type == 'timeout')) {
            //timeout hook
            $this->eventTimeout();



        } elseif (($this->type == 'push') && ($webHook->push_flag == 'true')) {
            //push answer hook
            $this->eventPushAnswer();




        } elseif (($this->type == 'qr') && ($webHook->qr_flag == 'true')) {
            //qrcode reading hook

            $this->eventQrCode();
        }








    }


    private function sendHook($data, $event) {


        $client = new Client();


        $pr=PushRequest::where('uniq_request_id', $this->uniqRequestID)->first();


        if ($pr->app->hook->type == 'form') {

            $dataArr['form_params']=$data;

        } elseif ($pr->app->hook->type == 'json') {

            $dataArr['json']=$data;

        }
//dd($dataArr);
        $dataArrRes = [
            'allow_redirects' => false,
            'connect_timeout' => 3.14,
            'headers'         => [
                'User-Agent'       => 'pushauth/hooks',
                'X-PushAuth-Event' => $event,
            ]


        ];
        $dataArrRes = array_merge($dataArrRes,$dataArr);


        try {

            $response = $client->request('POST', $pr->app->hook->payload_url, $dataArrRes);

        } catch (ConnectException $e) {

            return false;


        } catch (RequestException $e) {

            return false;

        } catch (ClientException $e) {

            return false;

        }

    }


    private function eventTimeout() {



        $pushRequest = PushRequest::where('uniq_request_id', $this->uniqRequestID)
            //->whereIn('answer',['true','false'])
            ->orderBy('id','asc')
            ->first();

            //no client response
        ($pushRequest->device) ? $clientEmail=$pushRequest->device->user->email : $clientEmail=Null;

        ($pushRequest->device) ? $clientPlatform=$pushRequest->device->os : $clientPlatform=Null;

        Log::info('fired timeout hooks: '.print_r($pushRequest,true));

        $dataHook=base64_encode(json_encode([
                'req_hash'=>$pushRequest->hash,
                'app_public_key'=>$pushRequest->app->public_key,
                'app_name'=>$pushRequest->app->name,
                'client_email'=>$clientEmail,
                'client_platform'=>$clientPlatform,
            ]));

            $data = ['hook'=>[
                'event'=>'client_response_timeout',
                'timestamp'=>Carbon::now()->timestamp,
                'data'=>$dataHook,
                'signature'=>base64_encode(hash_hmac('sha256',$dataHook,$pushRequest->app->private_key,true)),
            ]];

            //$data['hook']['signature'];

            //$clientsDevicesCount = PushRequest::where('uniq_request_id', $this->pushRequest->uniq_request_id)->count();

        if ($pushRequest->mode == 'route') {
        $totalRoutes = $pushRequest->routes()->count();
        $totalRoutesGroup = $pushRequest->routes()->groupBy('order')->count();



            if ((PushRequest::where('uniq_request_id', $this->uniqRequestID)
                    ->whereIn('answer', ['true', 'false'])
                    ->count() == 0)
            ) {

                PushRequest::where('uniq_request_id', $this->uniqRequestID)->first()->routes()->where('status','sended')->update([
                    'status'=>'timeout'
                ]);

                if ($pushRequest->app->hook->timeout_flag == 'true') {
                    return $this->sendHook($data, 'client_response_timeout');
                }
                else {
                    return false;
                }



            }


       /* //For Order answer
        if ($totalRoutes != $totalRoutesGroup) {



            //For all pushes
        }elseif ($totalRoutes == $totalRoutesGroup){
            if ((PushRequest::where('uniq_request_id', $this->uniq_request_id)
                    ->whereIn('answer', ['true', 'false'])
                    ->count() == 0)
            ) {

                PushRequest::where('uniq_request_id', $this->uniq_request_id)->routes()->where('status','sended')->update([
                    'status'=>'timeout'
                ]);
                return $this->sendHook($data, 'client_response_timeout');


            }
        }*/


        //For other push modes non route
        } else {

            if ((PushRequest::where('uniq_request_id', $this->uniqRequestID)
                    ->whereIn('mode', ['push'])
                    ->whereIn('answer', ['true', 'false'])
                    ->count() == 0)
            ) {


                /*PushRequest::where('uniq_request_id', $this->uniq_request_id)->routes()->where('status','sended')->update([
                    'status'=>'timeout'
                ]);*/
                if ($pushRequest->app->hook->timeout_flag == 'true') {
                    return $this->sendHook($data, 'client_response_timeout');
                } else{
                    return false;
                }


            }
        }

            return false;







    }

    private function eventPushAnswer() {



        $pushRequest = PushRequest::where('uniq_request_id', $this->uniqRequestID)
                                    ->whereIn('answer',['true','false'])
                                    ->orderBy('id','asc')
                                    ->first();


        ($pushRequest->device) ? $clientEmail=$pushRequest->device->user->email : $clientEmail=Null;

        ($pushRequest->device) ? $clientPlatform=$pushRequest->device->os : $clientPlatform=Null;


            $dataHook=base64_encode(json_encode([
                'req_hash'=>$pushRequest->hash,
                'app_public_key'=>$pushRequest->app->public_key,
                'app_name'=>$pushRequest->app->name,
                'client_email'=>$clientEmail,
                'client_platform'=>$clientPlatform,
                'answer'=>$pushRequest->answer,
                'response_timestamp'=>Carbon::parse($pushRequest->response_dt)->timestamp
            ]));

            $data = ['hook'=>[
                'event'=>'client_push_answer',
                'timestamp'=>Carbon::now()->timestamp,
                'data'=>$dataHook,
                'signature'=>base64_encode(hash_hmac('sha256',$dataHook,$pushRequest->app->private_key,true)),
            ]];




                return $this->sendHook($data, 'client_push_answer');







    }

    private function eventQrCode() {

        //dd('ok');

        $pushRequest = PushRequest::where('uniq_request_id', $this->uniqRequestID)
            ->whereIn('answer',['true','false'])
            ->orderBy('id','asc')
            ->first();

        $dataHook=base64_encode(json_encode([
            'req_hash'=>$pushRequest->hash,
            'app_public_key'=>$pushRequest->app->public_key,
            'app_name'=>$pushRequest->app->name,
            'client_email'=>$pushRequest->device->user->email,
            'client_platform'=>$pushRequest->device->os,
            'response_timestamp'=>Carbon::parse($pushRequest->response_dt)->timestamp
        ]));

        $data = ['hook'=>[
            'event'=>'client_read_qrcode',
            'timestamp'=>Carbon::now()->timestamp,
            'data'=>$dataHook,
            'signature'=>base64_encode(hash_hmac('sha256',$dataHook,$pushRequest->app->private_key,true)),
        ]];

        return $this->sendHook($data, 'client_read_qrcode');
    }


}
