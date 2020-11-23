<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class modificacionUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user,$accion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$accion)
    {
        $this->user=$user;
        $this->accion=$accion;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cheke_11@hotmail.com')->view('emails.modificacionUser');
    }
}
