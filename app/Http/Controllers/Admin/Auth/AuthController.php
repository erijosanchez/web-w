<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //muestra la vista del login de administrador
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    //Procesa el el login de los usuarios
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Update last login timestamp
        Auth::guard('admin')->user()->update([
            'last_login' => Carbon::now()
        ]);

        // Log successful login for audit
        activity()
            ->causedBy(Auth::guard('admin')->user())
            ->log('Admin login successful');

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        // Log logout for audit
        if (Auth::guard('admin')->check()) {
            activity()
                ->causedBy(Auth::guard('admin')->user())
                ->log('Admin logout');
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
