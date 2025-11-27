<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OVMCompleteMail extends Mailable
{
    use Queueable, SerializesModels;
     public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
  public function __construct($data)
    {
      $this->data = $data;
      // log::info($data);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
      public function build()
    {
      $data = $this->data;
         $email_id = config('setting.email_id');
        //  log::error($email_id);
        //  log::error('fttp');
        return $this->from($email_id)->subject('From Elina - Procedure for Uploading the Videos')->view('email.OVMComplete')->with('data',$this->data);
    }

}
