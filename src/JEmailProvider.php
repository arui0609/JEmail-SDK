<?php
/**
 *
 * User: songrui
 * Date: 2022/11/24
 * Email: <sr_yes@foxmail.com>
 */
namespace Arui\JEmail;

use Illuminate\Support\ServiceProvider;

class JEmailProvider extends ServiceProvider
{
    public function boot (){
        $this->publishes([
            __DIR__.'/config/j_cloud.php' => config_path('j_cloud.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('JEmail',function ($app){
            return new JEmail();
        });
    }
}
