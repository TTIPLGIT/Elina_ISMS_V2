<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;

class NewServiceProviderUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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

        $matchThese = ['active_flag' => '0', 'screen' => 'Service Provider'];
        $emailtemplate = EmailTemplate::where($matchThese)->get();
        $data = $this->data;
        $email_id = config('setting.email_id');

        return $this->from($email_id)
        ->subject($emailtemplate[0]->email_subject)
        ->html($emailtemplate[0]->email_body);

        // $email_id = config('setting.email_id');
        // return $this->from($email_id)->subject('From Elina  -  Your Form has been Registered')->view('email.siuseremail')->with('data', $this->data);
    }
}
