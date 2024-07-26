<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestricRegisterFailedMidlleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedControllers): Response
    {
        $routeAction = $request->route()->getAction('controller');
        $controllerAction = explode('@', $routeAction);
        $controller = $controllerAction[0];
        $controller = explode('\\', $controller);
        if (in_array($controller[4], $allowedControllers)) {
            return $next($request);
        }
        abort(404);
    }
}
