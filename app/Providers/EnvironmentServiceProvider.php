<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EnvironmentServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            return;
        }
        // ensure that this variables are required
        \Dotenv::required(
            [
                'DB_HOST',
                'DB_DATABASE',
                'DB_USERNAME',
                'DB_PASSWORD',
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
