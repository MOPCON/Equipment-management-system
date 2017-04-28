<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Staff;
use App\User;
use Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /**
         * 自動產生barcode
         */
        Staff::creating(function($staff) {
            $staff->barcode = 'ST'. str_pad((Staff::count() + 1), 5, '0', STR_PAD_LEFT);
        });

        /**
         * 密碼加密
         */
        User::creating(function($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
