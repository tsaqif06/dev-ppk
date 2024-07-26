<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Helpers\BarantinApiHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenApiBarantin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('admin')->check()) {
            return self::guardAdmin($request, $next);
        }
        abort(401);
    }
    private static function guardAdmin(Request $request, Closure $next)
    {
        $expire = Auth::guard('admin')->user()->expiry;
        if (now() < $expire) {
            return $next($request);
        }
        return self::userCheckUpdateToken($request, $next);

    }
    private static function userCheckUpdateToken(Request $request, Closure $next)
    {
        $res = self::userUpdateTokken();
        if ($res) {
            return $next($request);
        }
        abort(401);
    }
    private static function userUpdateTokken()
    {

        $refreshToken = BarantinApiHelper::refreshTokenApiBarantin(auth()->user()->refresh_token);
        if ($refreshToken['status'] == 200) {
            return auth()->user()->update([
                'access_token' => $refreshToken['data']['accessToken'],
                'refresh_token' => $refreshToken['data']['refreshToken'],
                'expiry' => Carbon::createFromFormat('Y-m-d\TH:i:sP', $refreshToken['data']['expiry'])->toDateTimeString(),
            ]);
        }
        self::logoutAndDelete();
    }
    private static function logoutAndDelete()
    {
        $user = Auth::guard('admin')->user();
        Auth::guard('admin')->logout();
        $user->delete();
        abort(401);
    }
}
