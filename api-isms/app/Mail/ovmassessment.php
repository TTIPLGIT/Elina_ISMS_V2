<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ovmassessment extends Mailable
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
        //  log::error($email_id);
        //  log::error($data['email_draft']);


         $ovm_assessment  = $data['ovm_assessment'];
        return $this->from($email_id)->subject('From Elina - SAIL Guide for '.$data['child_name'])->view('email.ovmassessment')->with('data',$this->data)->attach($ovm_assessment);
    }

}
