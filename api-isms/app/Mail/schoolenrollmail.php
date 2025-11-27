<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\EmailTemplate;

class schoolenrollmail extends Mailable
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

        $matchThese = ['active_flag' => '0', 'screen' => 'School Enrollment'];
        $emailtemplate = EmailTemplate::where($matchThese)->get();
        $data = $this->data;
        $email_id = config('setting.email_id');

        return $this->from($email_id)
            ->subject($emailtemplate[0]->email_subject)
            ->html($emailtemplate[0]->email_body);

        //     $email_id = config('setting.email_id');
        //     log::error($email_id);
        //    return $this->from($email_id)->subject('From Elina  -  Your Enrollment Form has been Registered')->view('email.schoolemail')->with('data',$this->data);


    }
}
