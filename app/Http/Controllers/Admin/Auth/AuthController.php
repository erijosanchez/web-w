<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Por favor, introduce un correo electrónico válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->with('error', 'Error en las credenciales');
        }

        $credentials = $request->only('email', 'password');
        
        // Intentar autenticar al usuario
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            
            // Verificar si el usuario está activo
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return redirect()
                    ->route('admin.login')
                    ->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
            }

            // Actualizar último login
            $admin->update([
                'last_login' => Carbon::now(),
            ]);

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', '¡Bienvenido al panel de administración!');
        }

        // Si la autenticación falla
        return redirect()
            ->back()
            ->with('error', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()
            ->route('admin.login')
            ->with('success', 'Has cerrado sesión correctamente');
    }
}
