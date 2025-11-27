<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ReferralRespondMail2 extends Mailable
{
    use Queueable, SerializesModels;
     public $data1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
  public function __construct($data1)
    {
      $this->data = $data1;
      // log::info($data);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
      public function build()
    {

         $email_id = config('setting.email_id');

        return $this->from($email_id)->subject('For Referral report Response')->view('email.referalresponseis2')->with('data',$this->data);
    }

}
