<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $name, $email, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build(){
        return $this->view('email.invite')
        ->with([
            'name' => $this->name,
            // 'invited_by' => $this->invited_by,
            // 'link' => $this->link,
            // 'role' => $this->role,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }
}
