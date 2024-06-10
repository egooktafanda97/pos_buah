<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if ($request->is('api/*')) {
            $request->headers->set('Accept', 'application/json');
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();
            $user = User::find($apy['sub']);
            auth()->login($user);
            $guards = ['api'];
        }
        $guards = ['web'];
        $this->authenticate($request, $guards);
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */



    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            abort(response()->json([
                "message" => "Unauthenticated",
                "status" => false,
                "code" => 401
            ], 401));
        } else {
            return redirect()->guest(route('login'));
        }
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
