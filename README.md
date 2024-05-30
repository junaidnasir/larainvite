# Larainvite
Larainvite is a Laravel package that allows existing users to invite others via email. 

It generates a one-time invitation code that can be sent as an invite link, and keeps track of the invitation status.

[![Latest Stable Version](https://poser.pugx.org/junaidnasir/larainvite/v/stable)](https://packagist.org/packages/junaidnasir/larainvite)
[![License](https://poser.pugx.org/junaidnasir/larainvite/license)](https://packagist.org/packages/junaidnasir/larainvite)
[![Total Downloads](https://poser.pugx.org/junaidnasir/larainvite/downloads)](https://packagist.org/packages/junaidnasir/larainvite)
[![Monthly Downloads](https://poser.pugx.org/junaidnasir/larainvite/d/monthly)](https://packagist.org/packages/junaidnasir/larainvite)

- v7 supports Laravel 11
- v6 supports Laravel 10
- v5 supports Laravel 9
- v4 supports Laravel 8
- v3 supports Laravel 5.8+, Laravel 6.0 and Laravel 7.0
- v2 supports Laravel 5.0 to 5.8
- v1 supports Laravel 4.*



## Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```bash
composer require junaidnasir/larainvite
```

add the package service provider in the providers array in `config/app.php`:

```php
Junaidnasir\Larainvite\LaraInviteServiceProvider::class
```

you may add the facade access in the aliases array:

```php
'Invite'  => Junaidnasir\Larainvite\Facades\Invite::class
```

publish the migration and config file:

```bash
php artisan vendor:publish --provider="Junaidnasir\Larainvite\LaraInviteServiceProvider"
```

migrate to create `user_invitation` table

```bash
php artisan migrate
```

edit your `User` model to include `larainviteTrait`
```php
use Junaidnasir\Larainvite\InviteTrait;
class user ... {
    use InviteTrait;
}
```


## Usage

You can use ***facade accessor*** to retrieve the package controller. Examples:

```php
$user = Auth::user();
//Invite::invite(EMAIL, REFERRAL_ID); 
$refCode = Invite::invite('email@address.com', $user->id);
//or 
//Invite::invite(EMAIL, REFERRAL_ID, EXPIRATION); 
$refCode = Invite::invite('email@address.com', $user->id, '2016-12-31 10:00:00');
//or
//Invite::invite(EMAIL, REFERRAL_ID, EXPIRATION, BEFORE_SAVE_CALLBACK); 
$refCode = Invite::invite($to, Auth::user()->id, Carbon::now()->addYear(1),
                      function(/* InvitationModel, see Configurations */ $invitation) use ($someValue) {
      $invitation->someParam = $someValue;
});
```

now create routes with `refCode`, when user access that route you can use following methods
```php
// Get route
$code = Request::input('code');
if( Invite::isValid($code))
{
    $invitation = Invite::get($code); //retrieve invitation modal
    $invited_email = $invitation->email;
    $referral_user = $invitation->user;

    // show signup form
} else {
    $status = Invite::status($code);
    // show error or show simple signup form
}
```
```php
// Post route
$code = Request::input('code');
$email = Request::input('signup_email');
if( Invite::isAllowed($code,$email) ){
    // Register this user
    Invite::consume($code);
} else {
    // either refCode is inavalid, or provided email was not invited against this refCode
}
```
with help of new trait you have access to invitations sent by user
```php
$user= User::find(1);
$invitations = $user->invitations;
$count = $user->invitations()->count();
```
## Events

***larainvite*** fires several [events](https://laravel.com/docs/master/events)

*  Junaidnasir\Larainvite\Events\Invited
*  Junaidnasir\Larainvite\Events\InvitationConsumed
*  Junaidnasir\Larainvite\Events\InvitedCanceled
*  Junaidnasir\Larainvite\Events\Expired

all of these events incloses `invitation modal` so you can listen to these events.
include listener in `EventServiceProvider.php`
```php
use Junaidnasir\Larainvite\Events\Invited;
use App\Listeners\SendUserInvitationNotification;

protected $listen = [
    Invited::class => [
        SendUserInvitationNotification::class,
    ],
];
```
`userInvite.php`
```php
public function handle($invitation)
{
    \Mail::queue('invitations.emailBody', $invitation, function ($m) use ($invitation) {
            $m->from('From Address', 'Your App Name');
            $m->to($invitation->email);
            $m->subject("You have been invited by ". $invitation->user->name);
        });
}
```

## Configurations

in `config/larainvite.php` you can set default expiration time in hours from current time.

```php
'expires' => 48
```

you can also change user model to be used, in `larainvite.php`
```php
'UserModel' => 'App\User'
```

you can also change invitation model to be used, in `larainvite.php`
```php
'InvitationModel' => 'App\Invitation'
```
