<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mail_regist;
    protected $mail_school_info;
    protected $mail_hotline;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_regist, $mail_school_info, $mail_hotline)
    {
        $this->mail_regist = $mail_regist;
        $this->mail_school_info = $mail_school_info;
        $this->mail_hotline = $mail_hotline;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.daftar')
                    ->subject('Pendaftaran - '.$this->mail_school_info->name)
                    ->with([
                        'daf' => $this->mail_regist,
                        'si' => $this->mail_school_info,
                        'hotline' => $this->mail_hotline,
                    ]);
    }
}
