<?php

namespace App\Providers;

use App\Modules\OAuth2;
use App\Modules\ZohoCrm;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::singleton('OAuth', function () {
            return new OAuth2();
        });

        App::singleton('ZohoCrm', function () {
            return new ZohoCrm();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    public function checkTokenDate()
    {

    }
}
