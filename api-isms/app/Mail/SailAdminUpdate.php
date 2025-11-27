<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SailAdminUpdate extends Mailable
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
    $child_name  = $data['child_name'];
    return $this->from($email_id)->subject('From Elina - SAIL Program Update for '. $child_name)->view('email.SailAdminUpdate')->with('data', $this->data);
  }
}
