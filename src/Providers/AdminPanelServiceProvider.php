<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 08.02.15
 * Time: 23:31
 */

namespace Cinject\AdminPanel\Providers;


use Cinject\AdminPanel\Console\Commands\Install;
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
        $this->commands(Install::class);

        $this->setRootControllerNamespace();

        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }

        $router->group(['namespace' => $this->namespace, 'prefix' => config('adminPanel.routePrefix')], function ($router) {

            $router->controller('auth', 'Auth\AuthController', [
                'getRegister'   => 'admin.register',
                'getLogin'      => 'admin.login',
                'getLogout'     => 'admin.logout',
            ]);

            $router->group(['middleware' => 'ap.permission', 'permission' => config('adminPanel.ap_permission')], function () {
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

        $this->publishes([
            __DIR__ . '/../../migrations' => base_path('database/migrations')
        ], 'migrate');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'adminPanel'
        );

        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'Cinject\AdminPanel\Services\Registrar'
        );
    }
}