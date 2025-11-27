<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendpaymentsuccessfullmail extends Mailable
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
    $register_receipt  = $data['register_receipt'];
    $payment_for  = $data['payment_for'];
    return $this->from($email_id)->subject('From Elina - ' . $payment_for . ' Payment Successfully Completed')->view('email.paymentsuccessfullmail')->with('data', $this->data)->attach($register_receipt);
  }
}
