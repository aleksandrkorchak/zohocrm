<?php

namespace App\Http\Middleware;

use App\Auth;
use Closure;
use DateInterval;
use DateTime;
use App\OAuth2 as OAuth;
use Illuminate\Support\Facades\App;


class CheckForAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = App::make('OAuth');
        $model = OAuth::first();
        $routeName = $request->route()->getName();

        //access_token is valid and route points to the auth page
        if ($auth->hasValidAccessToken() && $routeName === 'token') {
            return redirect()->route('home');
        }

        //If access_token is not valid and route not points to the auth page
        if (!$auth->hasValidAccessToken()) {
            $model->back_route = $routeName;
            $model->save();
            if ($routeName !== 'token') {
                return redirect()->route('token');
            }
        }

        return $next($request);
    }
}
