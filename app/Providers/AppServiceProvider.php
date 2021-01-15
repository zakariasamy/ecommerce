<?php

namespace App\Providers;

use App\Support\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;
use App\Support\Storage\Contracts\StorageInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // to make the storage work ( cart ) which is basket folder in app & support folder
        $this->app->bind(StorageInterface::class, function ($app) {
            return new SessionStorage('basket');
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
