<?php namespace App\Providers;

use App\Antony\DomainLogic\Modules\Cache\LaravelCache;
use App\Antony\DomainLogic\Modules\Images\ImageProcessor;
use App\Models\Product;
use App\Models\User;
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
        // ensure that our helper functions file is loaded
        require_once app_path() . '/Antony/helpers.php';
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        // laravel's user registrar
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );

        // binding the cache interface to our laravelCache class
        $this->app->bind('app\Antony\DomainLogic\Contracts\Caching\CacheInterface', function ($app) {
            return new LaravelCache($app['cache']);
        });

//        $this->app->when('App\Http\Controllers\Shared\PasswordController')
//            ->needs('Illuminate\Contracts\Auth\UserProvider')
//            ->give('Illuminate\Auth\EloquentUserProvider');

        // binding our imagingInterface to its counterpart
        $this->app->bind('app\Antony\DomainLogic\Contracts\Imaging\ImagingInterface', function ($app) {
            return new ImageProcessor();
        });


    }

}
