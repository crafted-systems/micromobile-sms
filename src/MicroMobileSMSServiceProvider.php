<?php

namespace CraftedSystems\MicroMobile;

use Illuminate\Support\ServiceProvider;

class MicroMobileSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/Config/micromobile.php' => config_path('micromobile.php'),
        ], 'micromobile_sms_config');

        $this->app->singleton(MicroMobileSMS::class, function () {
            return new MicroMobileSMS(config('micromobile'));
        });

        $this->app->alias(MicroMobileSMS::class, 'micromobile-sms');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/micromobile.php', 'micromobile'
        );
    }
}
