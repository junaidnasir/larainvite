<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiration Default
    |--------------------------------------------------------------------------
    |
    | Default Expiry time in Hours from current time.
    | i.e now() + expires (hours)
    |
    */
    'expires' => 48,

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    */
    'UserModel' => config('auth.providers.users.model', App\User::class),

    /*
    |--------------------------------------------------------------------------
    | Invitation Model
    |--------------------------------------------------------------------------
    */
    'InvitationModel' => 'Junaidnasir\Larainvite\Models\LaraInviteModel'
];
