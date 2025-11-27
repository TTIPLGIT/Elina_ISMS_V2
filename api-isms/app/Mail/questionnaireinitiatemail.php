<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class questionnaireinitiatemail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_id = config('setting.email_id');

        return $this->from($email_id)->subject('From Elina - User questionnaire sent Successfully')->view('email.questionnaireinitiationmail')->with('data',$this->data);
    }
}
