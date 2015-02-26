<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 25.02.15
 * Time: 1:35
 */

namespace Cinject\AdminPanel\Middleware;


use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

class Permission implements Middleware{

    /**
     * @var Guard
     */
    private $auth;

    function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $action = $request->route()->getAction();

        if ($this->auth->guest() || !$this->auth->user()->can($action['permission']))
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->route('admin.login');
            }
        }

        return $next($request);
    }
}