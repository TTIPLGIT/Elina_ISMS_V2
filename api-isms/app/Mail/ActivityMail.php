<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ActivityMail extends Mailable
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

    $email_id = config('setting.email_id');
    $data = $this->data;
    $subject = 'From Elina - SAIL Activity for ' . $data['child_name'];

    return $this->from($email_id)->subject($subject)->view('email.SailActivity')->with('data', $this->data);
  }
}
