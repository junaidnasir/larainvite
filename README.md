# larainvite
User (signup) invitation package for laravel


[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/junaidnasir/larainvite/master/LICENSE.txt)
[![Total Downloads](https://poser.pugx.org/junaidnasir/larainvite/downloads)](https://packagist.org/packages/junaidnasir/larainvite)

larainvite is a ***laravel*** package, to allow existing users to invite others by email.

It generates referral code and keep track of status.


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
php artisan vendor:publish"
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
```

now create routes with `refCode`, when user access that route you can use following methods
```php
$code = Request::input('code');
if( Invite::isValid($code))
{
    $invitation = Invite::get($code); //retrieve invitation modal
    $invited_email = $invitation->email;
    $referral_user = $invitation->user;

    // show signup form
    
    Invite::consume($code);
} else {
    $status = Invite::status($code);
    // show error or show simple signup form
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

*  'junaidnasir.larainvite.invited' 
*  'junaidnasir.larainvite.consumed' 
*  'junaidnasir.larainvite.canceled' 
*  'junaidnasir.larainvite.expired' 

all of these events incloses `invitation modal` so you can listen to these events.
include listener in `EventServiceProvider.php`
```php
protected $listen = [
    'junaidnasir.larainvite.invited' => [
        'App\Listeners\userInvite',
    ],
];
```
`userInvite.php`
```php
public function handle($invitation)
{
    \Mail::queue('invitations.emailBody', $data, function ($m) use ($data) {
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

to change user model, default set to ('App\User') add this in your `AppServiceProvider.php` boot function 
```php
public function boot()
{
    Invite::setUserModel('App\Models\User');
}
```