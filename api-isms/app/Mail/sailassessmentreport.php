<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sailassessmentreport extends Mailable
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
    $ovm_report  = $data['ovm_report'];
    $child_name = $data['child_name'];
    return $this->from($email_id)->subject('From Elina - Recommendation Report for ' . $child_name)->view('email.sail_recommendation')->with('data', $this->data)->attach($ovm_report);
  }
}
