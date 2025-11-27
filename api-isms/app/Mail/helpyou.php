<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class helpyou extends Mailable
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
    // $attachment  = 'C:\Apache24\htdocs\Elina_ISMS\api-isms/.env'; //Location of the File to be sent
    // $attachment = public_path().'/newsletter/newsletter.pdf';
    return $this->from($email_id)->subject('From ELiNA: Thank you for starting your journey with us.')->view('email.helpyou')->with('data', $this->data);
    // return $this->from($email_id)->subject('From Elina - Recommendation Report')->view('email.Webportal_Mail')->with('data', $this->data)->attach($ovm_report);
  }
}
