<?php

namespace App\Jobs;

use App\Mail\adminpaymentinitiation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class adminpayinitiate implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->data = $data;
        //
        // $ad = (($data['email_users'])); 
        // Log::info( $data);
        // Log::info($data['email_users']);
        // for($i=0;$i<count($data->email_users);$i++){
            //  Log::info( "qqq");
            // Mail::to('')->send(new sendovmmail());
            // }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $data = $this->data;
        // log::info("asas");
        // log::info($data);
        // for($i=0;$i<count($data->email_users);$i++){
            Mail::to('pradeep@talentakeaways.com')->send(new adminpaymentinitiation());
            Mail::to('pradeep@talentakeaways.com')->send(new adminpaymentinitiation());
          
            DB::disconnect('foo');
        // }
        
    }
}

