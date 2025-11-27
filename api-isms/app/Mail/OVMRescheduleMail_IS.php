<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OVMRescheduleMail_IS extends Mailable
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
    $child_name  = $data['child_name'];
    // Combine $mailSubject and $child_name in the subject
    $subject = 'From Elina - ' . $mailSubject . ' - ' . $child_name;
    return $this->from($email_id)->subject($subject)->view('email.OVMReschedule_IS')->with('data', $this->data);
  }
}
