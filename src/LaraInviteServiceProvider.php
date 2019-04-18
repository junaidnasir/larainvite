<?php

namespace Junaidnasir\Larainvite;

use Illuminate\Support\ServiceProvider;

class LaraInviteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/larainvite.php' => config_path('larainvite.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/Migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/larainvite.php', 'larainvite');
        $this->app->singleton('invite', function ($app) {
            $laravelImplementation = new \Junaidnasir\Larainvite\LaraInvite();
            return new \Junaidnasir\Larainvite\UserInvitation($laravelImplementation);
        });
    }

    public function provides()
    {
        return ['invite'];
    }
}
