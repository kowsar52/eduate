<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherInfo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $username, $name;

    public function __construct($username, $name)
    {
        $this->username = $username;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Eduate Account Information || Eduate')->view('email.teacher')->with(['username' => $this->username,'name' =>$this->name, 'password' => '11223344']);
    }
}
