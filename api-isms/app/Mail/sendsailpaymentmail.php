<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class sendsailpaymentmail extends Mailable
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
    $sail_consent = $data['sail_invoice'];
    // return $this->from($email_id)->subject('From Elina  -  Your SAIL Payment Link has been Successfully sent')->view('email.sailpaymentinitiatemail')->with('data',$this->data)->attach($sail_invoice)->attach($sail_consent);
    $email = $this->from($email_id)->subject('From Elina - Your SAIL Payment Link has been Successfully sent')->view('email.sailpaymentinitiatemail')->with('data', $this->data)->attach($sail_consent);
    return $email;
  }
}
