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
        'adminPanel.auth' => 'Cinject\AdminPanel\Middleware\Authenticate',
        'adminPanel.guest' => 'Cinject\AdminPanel\Middleware\RedirectIfAuthenticated',
    ];


    public function boot(Router $router)
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }

        $router->group(['namespace' => $this->namespace, 'prefix' => 'admin'], function ($router) {
            require __DIR__ . '/../routes.php';
        });


        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'adminPanel');

//        $this->publishes([
//            __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/adminPanel'),
//        ]);

        $this->publishes([
            __DIR__.'/../../resources/assets' => base_path('resources/adminAssets')
        ], 'assets');
    }
}