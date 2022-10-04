<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiveMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mail_data;
    protected $mail_school_info;
    protected $mail_hotline;
    protected $mail_selection;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data, $mail_school_info, $mail_hotline, $mail_selection)
    {
        $this->mail_data = $mail_data;
        $this->mail_school_info = $mail_school_info;
        $this->mail_hotline = $mail_hotline;
        $this->mail_selection = $mail_selection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.diterima')
                    ->subject('Diterima - '.$this->mail_school_info->name)
                    ->with([
                        'da' => $this->mail_data,
                        'si' => $this->mail_school_info,
                        'hotline' => $this->mail_hotline,
                        'sel' => $this->mail_selection,
                    ]);
    }
}
