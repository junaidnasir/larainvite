<?php

namespace Junaidnasir\Larainvite\Models;

use Illuminate\Database\Eloquent\Model;

class LaraInviteModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_invitations';
    
    /**
     * User Model (referral)
     * 
     * @var string
     */
    protected static $userModel='App\User';

    /**
     * Referral User
     */
    public function user()
    {
        return $this->belongsTo(static::$userModel);
    }

    /**
     * Set User Model
     * call this function in AppServiceProvidor's boot() function
     * to overwrite default
     */
    public static function setUserModel($model)
    {
        static::$userModel = $model;
    }
}
