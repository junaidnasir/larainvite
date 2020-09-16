<?php

namespace Junaidnasir\Larainvite\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Junaidnasir\Larainvite\Models\LaraInviteModel;

class InvitationCanceled
{
    use Dispatchable, SerializesModels;

    public $invitation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LaraInviteModel $invitation)
    {
        $this->invitation = $invitation;
    }
}
