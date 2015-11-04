<?php
namespace Nebo15\LumenIntercom;

use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;
use Nebo15\LumenIntercom\Exceptions\LumenIntercomException;

class IntercomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Nebo15\LumenIntercom\Intercom', function (Application $app) {
            $app_id = env('INTERCOM_APP_ID', false);
            $app_key = env('INTERCOM_APP_KEY', false);
            if (!$app_id || !$app_key) {
                throw new LumenIntercomException('set intercom keys for LumenIntercom');
            }
            return new Intercom($app_id, $app_key);
        });
    }
}
