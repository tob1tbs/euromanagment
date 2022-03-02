<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;

class ModularProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

        $modules = config('modular.modules');
        $path = config('modular.path');

        if($modules) {
            Route::group([
                'prefix'=>''
            ], function() use($modules, $path) {
                foreach ($modules as $key => $mod) {
                    $relativePath = "/$mod";
                    Route::middleware('web')
                        ->group(function() use($mod, $relativePath, $path) {
                            $this->getWebRoutes($mod, $relativePath, $path);
                        });
                }
            });
        }

        $this->app['view']->addNamespace('Pub',base_path().'/resources/views/Pub');
    }

    private function getWebRoutes($mod, $relativePath, $path)
    {

        $routesPath = $path.$relativePath.'/Routes/web.php';
        if(file_exists($routesPath)) {
            Route::group(
                [
                    'middleware' => $this->getMiddleware($mod),
                ],
                function() use ($mod, $routesPath) {
                    Route::namespace("App\Modules\\$mod\\Controllers")->
                            group($routesPath);
                }

            );
        }

    }

    private function getMiddleware($mod, $key = 'web')
    {
        $middleware = [];

        $config = config('modular.groupMidleware');

        if(isset($config[$mod])) {
            if(array_key_exists($key, $config[$mod])) {
                $middleware = array_merge($middleware, $config[$mod][$key]);
            }
        }

        return $middleware;
    }
}
