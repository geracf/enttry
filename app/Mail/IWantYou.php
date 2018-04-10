<?php

namespace App\Mail;

use App\Offer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IWantYou extends Mailable
{
    use Queueable, SerializesModels;
    public $student;
    public $offer;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $student, Offer $offer, $message)
    {
        $this->student = $student;
        $this->offer = $offer;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@jobshere.com')
                    ->subject('Alguien quiere que apliques a su oferta!')
                    ->markdown('emails.offers.wanted');
    }
}
