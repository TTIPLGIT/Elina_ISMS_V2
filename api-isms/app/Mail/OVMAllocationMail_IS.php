<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OVMAllocationMail_IS extends Mailable
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
    $email_id = config('setting.email_id');
    $data = $this->data;
    $mailSubject = $data['mailSubject'];
    return $this->from($email_id)->subject('From Elina - Overview Meeting Scheduled')->view('email.OVMAllocation_IS')->with('data', $this->data);
  }
}
