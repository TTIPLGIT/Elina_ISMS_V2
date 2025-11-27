<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendenrollmail extends Mailable
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

        $email_id = config('setting.email_id');
        $file = config('setting.document_storage_path') . '/demo_document/Attendance.xlsx';
        return $this->from($email_id)->subject('From Elina - Your Enrollment Form has been Registered')
            ->view('email.welcomemail')
            ->attach($file)
            ->with('data', $this->data);
    }
}
