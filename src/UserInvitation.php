<?php namespace Junaidnasir\Larainvite;

use \Exception;
use Carbon\Carbon;
use Junaidnasir\Larainvite\InvitationInterface;

/**
* User Invitation class
*/
class UserInvitation
{
    private $interface;
    function __construct(InvitationInterface $interface)
    {
        $this->interface = $interface;
    }

    public function invite($email, $referral, $expires = null, $beforeSave = null)
    {
        $expires = (is_null($expires)) ? Carbon::now()->addHour(config('larainvite.expires')) : $expires;
        $this->validateEmail($email);
        return $this->interface->invite($email, $referral, $expires, $beforeSave);
    }

    public function get($code)
    {
        return $this->interface->setCode($code)->get();
    }

    public function status($code)
    {
        return $this->interface->setCode($code)->status();
    }

    public function isValid($code)
    {
        return $this->interface->setCode($code)->isValid();
    }

    public function isExpired($code)
    {
        return $this->interface->setCode($code)->isExpired();
    }

    public function isPending($code)
    {
        return $this->interface->setCode($code)->isPending();
    }

    public function isAllowed($code, $email)
    {
        return $this->interface->setCode($code)->isAllowed($email);
    }
    public function consume($code)
    {
        return $this->interface->setCode($code)->consume();
    }

    public function cancel($code)
    {
        return $this->interface->setCode($code)->cancel();
    }

    public function reminder($code)
    {
        return $this->interface->setCode($code)->reminder();
    }
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid Email Address", 1);
        }
        return $this;
    }
}
