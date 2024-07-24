<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    

    public function __construct($token) {
        $this->token = $token;
    }

    public function build() {
        return $this->from('hanjan.6425@gmail.com', 'HanJan')
                ->subject('이메일 인증')
                ->view('emails.verification') // views/emails/verification.blade.php 파일
                ->with([
                    'token' => $this->token,
                ]);
    }
}
