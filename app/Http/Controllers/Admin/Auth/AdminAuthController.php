<?php

namespace App\Http\Controllers\Admin\Auth;

//Importa las dependencias necesarias
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\AuthenticationService;
use App\Http\Requests\Auth\AdminLoginRequest;

class AdminAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle admin login request
     *
     * @param AdminLoginRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function login(AdminLoginRequest $request)
    {
        try {
            // Verificar si el usuario está bloqueado por demasiados intentos
            $this->checkTooManyAttempts($request);

            // Disparar evento de intento de login
            event(new LoginAttempt($request->email));

            // Validar credenciales
            if (!$this->attemptLogin($request)) {
                // Incrementar contador de intentos fallidos
                RateLimiter::hit($this->throttleKey($request));

                // Disparar evento de login fallido
                event(new LoginFailed($request->email));

                throw ValidationException::withMessages([
                    'email' => [trans('auth.failed')],
                ]);
            }

            // Login exitoso
            $admin = Auth::guard('admin')->user();

            // Verificar si la cuenta está activa
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                throw ValidationException::withMessages([
                    'email' => ['Tu cuenta está desactivada. Contacta al administrador.'],
                ]);
            }

            // Actualizar último login
            $admin->update([
                'last_login' => now(),
                'last_login_ip' => $request->ip()
            ]);

            // Disparar evento de login exitoso
            event(new LoginSuccess($admin));

            // Limpiar intentos fallidos
            RateLimiter::clear($this->throttleKey($request));

            // Generar token si es API
            if ($request->wantsJson()) {
                $token = $admin->createToken('admin-token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'admin' => $admin->load('roles.permissions')
                ]);
            }

            // Redireccionar si es web
            return redirect()->intended(route('admin.dashboard'));

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Error en la autenticación',
                    'errors' => [$e->getMessage()]
                ], 422);
            }

            return back()->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param LoginRequest $request
     * @return bool
     */
    protected function attemptLogin(LoginRequest $request)
    {
        return Auth::guard('admin')->attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        );
    }

    /**
     * Check if too many login attempts have been made.
     *
     * @param Request $request
     * @throws ValidationException
     */
    protected function checkTooManyAttempts(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'email' => [
                    trans('auth.throttle', [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60),
                    ]),
                ],
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @param Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return redirect()->route('admin.login');
    }
}
