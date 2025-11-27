<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class IS_CancellationMail extends Mailable
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
    Log::error($email_id);
    Log::error('hitted the controller');
    Log::error($data);
    $subject = 'From Elina - IS-Coordinator Cancellation Mail for ' . $data['child_name'];
    return $this->from($email_id)->subject($subject)->view('email.is_coordinatorcancellation')->with('data', $this->data);
  }
}
