<?php

namespace PushAuth\Jobs;

use PushAuth\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWeb extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
/*        Redis::publish('ZEN-channel', json_encode([
            'msgType' => 'webPush',
            'login' => $this->login,
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,

        ]));*/

    }
}
