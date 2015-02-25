<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 08.02.15
 * Time: 23:31
 */

namespace Cinject\AdminPanel\Providers;


use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{

    protected $namespace = 'Cinject\AdminPanel\Controllers';

    protected $routeMiddleware = [
        'ap.auth' => 'Cinject\AdminPanel\Middleware\Authenticate',
        'ap.guest' => 'Cinject\AdminPanel\Middleware\RedirectIfAuthenticated',
        'ap.permission' => 'Cinject\AdminPanel\Middleware\Permission',
    ];


    public function boot(Router $router)
    {
        $this->setRootControllerNamespace();

        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }

        $router->group(['namespace' => $this->namespace, 'prefix' => config('adminPanel.routePrefix')], function ($router) {
            $router->controller('auth', 'Auth\AuthController');

            $router->group(['middleware' => 'ap.permission', 'permission' => 'ap'], function () {
                require __DIR__ . '/../routes.php';
            });
        });


        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'adminPanel');

        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('adminPanel.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => base_path('resources/adminAssets')
        ], 'assets');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'adminPanel'
        );
    }
}