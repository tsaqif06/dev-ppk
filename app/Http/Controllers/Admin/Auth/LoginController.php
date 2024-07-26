<?php

namespace App\Http\Controllers\Admin\Auth;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    public function index(): View
    {
        return view('auth.admin.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)//: RedirectResponse
    {

        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);



        $res = BarantinApiHelper::loginApiBarantin($request->username, $request->password);

        $user = $res['data'];

        if ($res['status'] !== '200' || $user['detil'][0]['apps_id'] !== env('APP_ID', 'APP003')) {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $roleInstance = $user['detil'][0];

        $admin = Admin::updateOrCreate(['uid' => $user['uid']], [
            'uid' => $user['uid'],
            'uname' => $user['uname'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'roles_id' => $roleInstance['roles_id'],
            'apps_id' => $roleInstance['apps_id'],
            'upt_id' => $user['upt'] ?? null,
            'role_name' => $roleInstance['role_name'],
            'access_token' => $user['accessToken'],
            'refresh_token' => $user['refreshToken'],
            'expiry' => Carbon::createFromFormat('Y-m-d\TH:i:sP', $user['expiry'])->toDateTimeString(),
            'password' => $request->password,
        ]);


        if (Auth::guard('admin')->attempt(['uid' => $admin->uid, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard.index');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request): JsonResponse
    {

        $user = Auth::guard('admin')->user();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Menghapus user dari database
        if ($user) {
            $user->delete();
        }

        return response()->json(['message' => 'User logged out and deleted successfully']);
    }


}
