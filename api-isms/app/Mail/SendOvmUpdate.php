<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOvmUpdate extends Mailable
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
        $consent_form  = $data['imagename'];
        return $this->from($email_id)->subject('From Elina - OVM 2 Meeting has been scheduled')->view('email.demolinkinvite')->with('data', $this->data)->attach($consent_form);
    }
}
