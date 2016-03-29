<?php

namespace Junaidnasir\Larainvite;

interface InvitationInterface
{
    /**
     * Create new invitation
     * @param  string   $email      Email to invite
     * @param  int      $referral   Referral 
     * @param  DateTime $expires    Expiration Date Time
     * @return string               Referral code
     */
    public function invite($email, $referral, $expires);
    
    /**
     * Set referral code and LaraInviteModel instance
     * @param string $code referral Code
     */
    public function setCode($code);

    /**
     * Returns Invitation record
     * @return Junaidnasir\Larainvite\Models\LaraInviteModel
     */
    public function get();

    /**
     * Returns invitation status
     * @return string pending | successful | expired | canceled
     */
    public function status();

    /**
     * Set invitation as successful
     * @return boolean true on success | false on error
     */
    public function consume();

    /**
     * Cancel an invitation
     * @return boolean true on success | false on error
     */
    public function cancel();

    /**
     * check if invitation is valid
     * @return boolean
     */
    public function isValid();

    /**
     * check if invitation has expired
     * @return boolean
     */
    public function isExpired();
    
    /**
     * check if invitation status is pending
     * @return boolean
     */
    public function isPending();
}
