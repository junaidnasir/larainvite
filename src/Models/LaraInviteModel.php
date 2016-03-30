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
     * Referral User
     */
    public function user()
    {
        return $this->belongsTo(config('larainvite.UserModel'));
    }
}
