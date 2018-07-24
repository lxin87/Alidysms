<?php

namespace Lxin87\Alidysms;

use Illuminate\Support\ServiceProvider;

class AliDySmsServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //发布配置文件
        $this->publishes([
            __DIR__.'/config/sms.php' => config_path('sms.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Alisms', function () {
            return new AliSmsService();
        });
    }

    public function provides()
    {
        return ['Alisms'];
    }
}
