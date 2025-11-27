<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Models\EmailTemplate;

class SendMail extends Mailable
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
    $consent_form  = $data['consent_form'];
    // Log::error($data);
    $matchThese = ['active_flag' => '0', 'screen' => 'Enrollment'];
    $emailtemplate = EmailTemplate::where($matchThese)->get();
    // Log::error($emailtemplate);
    return $this->from($email_id)
      ->subject($emailtemplate[0]->email_subject)
      ->html($emailtemplate[0]->email_body)
      ->attach($consent_form);

    // return $this->from($email_id)->subject('From Elina  -  Your Enrollment Form has been Registered')->view('email.newform')->with('data', $this->data)->attach($consent_form);
  }
}
