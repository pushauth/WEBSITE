<?php

namespace PushAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use PushAuth\PushRequest;

class RemoveQr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RemoveQr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove QR';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {



        PushRequest::where('mode','qr')->whereNull('device_id')->delete();


        $this->comment(PHP_EOL.'ok!'.PHP_EOL);
    }
}
