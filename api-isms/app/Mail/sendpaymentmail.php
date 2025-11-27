<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class sendpaymentmail extends Mailable
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
    // Parent
    $data = $this->data;
    $email_id = config('setting.email_id');
    $register_invoice  = $data['register_invoice'];
    return $this->from($email_id)->subject('From Elina - Registration Payment Initiation')->view('email.paymentinitiatemail')->with('data', $this->data)->attach($register_invoice);
  }
}
