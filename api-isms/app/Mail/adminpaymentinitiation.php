<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class adminpaymentinitiation extends Mailable
{
    use Queueable, SerializesModels;
    //  public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
  public function __construct()
    {
        // $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
      public function build()
    {

         $email_id = config('setting.email_id');

        return $this->from($email_id)->subject('From Elina - User payment Initiated Successfully')->view('email.adminpaymentinitiationmail');
    }

}
