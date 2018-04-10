<?php

namespace App\Mail;

use App\User;
use App\Offer;
use App\Student\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferApplied extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;
    public $student;
    public $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $student, Offer $offer, Application $application)
    {
        $this->offer = $offer;
        $this->student = $student;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.offers.applied');
    }
}
