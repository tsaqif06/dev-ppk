<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PengajuanUpdatePj;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckDataUpdatePj
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        $token = $request->route('token');
        $barantinId = $request->route('barantin_id');
        $response = self::cekUpdateToken($token, $barantinId);
        if ($response instanceof RedirectResponse || $response instanceof JsonResponse) {
            return $response;
        }
        return $next($request);
    }
    private static function cekUpdateToken(string $token, string $barantin_id)
    {
        $data = PengajuanUpdatePj::where('update_token', $token)->where('pj_barantin_id', $barantin_id)->where('persetujuan', 'disetujui')->where('status_update', 'proses')->first();
        if ($data) {
            if (now() > $data->expire_at) {
                $data->update(['status_update', 'gagal']);
                if (request()->ajax()) {
                    return response()->json(['message' => 'Token tidak valid, Silahkan ajukan ulang.'], 400);
                }
                return redirect()->route('barantin.pjk.message')->with(['message_token' => 'Token tidak valid, Silahkan ajukan ulang.']);
            }
            return true;
        }
        return redirect()->route('barantin.pjk.message')->with(['message_token' => 'Token tidak valid, Silahkan ajukan ulang.']);
    }
}
