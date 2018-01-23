<?php

namespace Mavinoo\LaravelSmsIran\Laravel;

use Mavinoo\LaravelSmsIran\Gateways\AzinwebGateway;
use Mavinoo\LaravelSmsIran\Gateways\GatewayAbstract;
use Illuminate\Support\ServiceProvider;
use Mavinoo\LaravelSmsIran\Sms;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
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
	    $this->mergeConfigFrom(
		    __DIR__.'/config/sms.php', 'sms'
	    );

		$this->app->singleton('Sms', function(){
			return new Sms();
		});
    }
}
