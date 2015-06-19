<?php namespace App\Providers;

use app\Antony\DomainLogic\Contracts\Caching\CacheInterface;
use app\Antony\DomainLogic\Contracts\Imaging\ImagingInterface;
use app\Antony\DomainLogic\Modules\Cache\LaravelCache;
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
     * bindings with the application. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        // binding the cache interface to our laravelCache class
        $this->app->bind(CacheInterface::class, function ($app) {
            return new LaravelCache($app['cache']);
        });

        // binding our imagingInterface to its counterpart
        $this->app->bind(ImagingInterface::class, function ($app) {
            return new ImageProcessor();
        });


    }

}
