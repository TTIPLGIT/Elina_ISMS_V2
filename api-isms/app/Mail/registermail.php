<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\EmailTemplate;

class registermail extends Mailable
{
    use  Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $matchThese = ['active_flag' => '0', 'screen' => 'Registration'];
        $emailtemplate = EmailTemplate::where($matchThese)->get();
        $data = $this->data;
        $email_id = config('setting.email_id');
        $replacements = [
            '[[isms_url]]' => config('setting.web_portal'),
            '%isms_url%' => config('setting.web_portal'),
        ];

        $email_body = str_replace(array_keys($replacements), array_values($replacements), $emailtemplate[0]->email_body);

        return $this->from($email_id)->subject($emailtemplate[0]->email_subject)->view('email.registrationemail')->with('data', $data)->with('datac', $email_body);

        // return $this->from($email_id)
        // ->subject($emailtemplate[0]->email_subject)
        // ->html($emailtemplate[0]->email_body);

    }
}
