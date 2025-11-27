<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class QuestionnairerequestMail1 extends Mailable
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
    $mailSubject = $data['mail_subject'];
    $child_name  = $data['child_name'];
    $subject = 'From Elina - ' . $mailSubject . ' - ' . $child_name;
    return $this->from($email_id)->subject($subject)->view('email.Questionnairerequestisc2')->with('data', $this->data);

  }
}
