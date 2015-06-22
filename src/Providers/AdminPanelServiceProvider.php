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
use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{

    protected $namespace = 'Cinject\AdminPanel\Controllers';

    protected $routeMiddleware = [
        'ap.auth' => \Cinject\AdminPanel\Middleware\Authenticate::class,
        'ap.guest' => \Cinject\AdminPanel\Middleware\RedirectIfAuthenticated::class,
        'ap.permission' => \Cinject\AdminPanel\Middleware\Permission::class,
    ];


    public function boot(Router $router)
    {
        $this->commands(Install::class);

        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->middleware($key, $middleware);
        }

        $groupOptions = ['namespace' => $this->namespace];

        if (config('adminPanel.subDomain'))
            $groupOptions['domain'] = config('adminPanel.routePrefix') . '.' . preg_replace("/^(.*?)\.(.*)$/", "$2", \Request::server('SERVER_NAME'));
        else
            $groupOptions['prefix'] = config('adminPanel.routePrefix');

        $router->group($groupOptions, function (Router $router) {

            $router->controller('auth', 'Auth\AuthController', [
                'getRegister' => 'admin.register',
                'getLogin' => 'admin.login',
                'getLogout' => 'admin.logout',
            ]);

            $router->group(['middleware' => 'ap.permission', 'permission' => config('adminPanel.ap_permission')], function (Router $route) {

                $route->get('/', ['as' => 'admin.home', function () {
                    return view('adminPanel::hello');
                }]);

                $route->controller('ajax', 'AjaxController');

                $route->resource('user', 'UserController', ['as' => 'admin']);

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