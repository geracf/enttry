<?php

namespace App\Mail;

use App\User;
use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrganizationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;
    public $organization;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Organization $organization, $plan)
    {
        $this->user = $user;
        $this->organization = $organization;
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.organization.created')
            ->subject('Tu cuenta ya está activa!');
    }
}
