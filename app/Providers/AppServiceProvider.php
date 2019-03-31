<?php

namespace App\Providers;

use Hash;
use App\User;
use App\Staff;
use App\RaiseEquipment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

        /*
         * 自動產生barcode
         */
        Staff::creating(function ($staff) {
            $staff->barcode = 'ST' . str_pad((((int) str_replace('ST', '', Staff::pluck('barcode')->last())) + 1), 3, '0', STR_PAD_LEFT);
        });

        RaiseEquipment::creating(function ($equipment) {
            $equipment->barcode = 'RE' . str_pad((((int) str_replace('RE', '', RaiseEquipment::pluck('barcode')->last())) + 1), 3, '0', STR_PAD_LEFT);
        });

        /*
         * 密碼加密
         */
        User::creating(function ($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = bcrypt($user->password);
            }
        });

        Collection::macro('plucks', function ($assoc) {
            return $this->map(function ($item) use ($assoc) {
                $list = [];
                foreach ($assoc as $key) {
                    $list[$key] = data_get($item, $key);
                }

                return $list;
            }, new static);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
