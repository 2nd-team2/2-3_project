<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @param User $userInfo
     */
    public function __construct(User $userInfo)
    {
        $this->userName = $userInfo->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome')
                    ->subject('Welcome to Our Website')
                    ->with([
                        'userName' => $this->userName,
                        // 기타 필요한 데이터
                    ]);
    }
}
