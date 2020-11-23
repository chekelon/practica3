<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Comment;
use App\User;

class comentarioNew extends Mailable
{
    use Queueable, SerializesModels;

        public $comment,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,Comment $comment)
    {
        $this->comment=$comment;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cheke_11@hotmail.com')->view('emails.comentarioNuevo');
    }
}
