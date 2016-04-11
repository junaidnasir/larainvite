<?php

namespace Junaidnasir\Larainvite;

trait InviteTrait
{
    /**
     * return all invitation as laravel collection
     * @return hasMany invitation Models
     */
    public function invitations()
    {
        return $this->hasMany('Junaidnasir\Larainvite\Models\LaraInviteModel');
    }

    /**
     * return successful initation by a user
     * @return hasMany
     */
    public function invitationSuccess()
    {
        return $this->invitations()->where('status', 'successful');
    }
    /**
     * return pending invitations by a user
     * @return hasMany
     */
    public function invitationPending()
    {
        return $this->invitations()->where('status', 'pending');
    }
}
