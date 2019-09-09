<?php namespace Junaidnasir\Larainvite;

use \Exception;
use Carbon\Carbon;
use Junaidnasir\Larainvite\InvitationInterface;

/**
* User Invitation class
*/
class UserInvitation
{
    /**
     * @var \Junaidnasir\Larainvite\InvitationInterface
     */
    private $interface;

    /**
     * UserInvitation constructor.
     * @param \Junaidnasir\Larainvite\InvitationInterface $interface
     */
    public function __construct(InvitationInterface $interface)
    {
        $this->interface = $interface;
    }

    /**
     * @param $email
     * @param $referral
     * @param null $expires
     * @param null $beforeSave
     * @return string
     * @throws Exception
     */
    public function invite($email, $referral, $expires = null, $beforeSave = null)
    {
        $expires = $expires === null ? Carbon::now()->addHour(config('larainvite.expires')) : $expires;
        $this->validateEmail($email);
        return $this->interface->invite($email, $referral, $expires, $beforeSave);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function get($code)
    {
        return $this->interface->setCode($code)->get();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function status($code)
    {
        return $this->interface->setCode($code)->status();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function isValid($code)
    {
        return $this->interface->setCode($code)->isValid();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function isExpired($code)
    {
        return $this->interface->setCode($code)->isExpired();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function isPending($code)
    {
        return $this->interface->setCode($code)->isPending();
    }

    /**
     * @param $code
     * @param $email
     * @return mixed
     */
    public function isAllowed($code, $email)
    {
        return $this->interface->setCode($code)->isAllowed($email);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function consume($code)
    {
        return $this->interface->setCode($code)->consume();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function cancel($code)
    {
        return $this->interface->setCode($code)->cancel();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function reminder($code)
    {
        return $this->interface->setCode($code)->reminder();
    }

    /**
     * @param $email
     * @return $this
     */
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Invalid Email Address', 1);
        }
        return $this;
    }
}
