<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

	   if(!$this->app->environment('local')) {
		    URL::forceScheme('https');
	} 
        Model::unguard();

        Gate::define('isAdmin', function (User $user) {
            return $user->nivel_acesso != 3;
        });
    }
}
