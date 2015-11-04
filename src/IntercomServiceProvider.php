<?php
namespace Nebo15\LumenIntercom;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;

class IntercomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('intercom', function (Application $app) {

        });
    }
}
