<?php
namespace Junaidnasir\Larainvite\Facades;

use Illuminate\Support\Facades\Facade;

class Invite extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'invite';
    }
}
