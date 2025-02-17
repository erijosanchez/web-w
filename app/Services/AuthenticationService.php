<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationService
{
    /**
     * Verificar credenciales del administrador
     *
     * @param string $email
     * @param string $password
     * @return Admin|null
     */
    public function verifyCredentials(string $email, string $password): ?Admin
    {
        $admin = Admin::where('email', $email)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            return $admin;
        }

        return null;
    }

    /**
     * Verificar si el administrador tiene los permisos necesarios
     *
     * @param Admin $admin
     * @param string|array $permissions
     * @return bool
     */
    public function hasPermissions(Admin $admin, $permissions): bool
    {
        return $admin->hasPermission($permissions);
    }

    /**
     * Registrar intento de inicio de sesión fallido
     *
     * @param string $email
     * @param string $ip
     * @return void
     */
    public function logFailedAttempt(string $email, string $ip): void
    {
        Log::warning('Failed login attempt', [
            'email' => $email,
            'ip' => $ip,
            'time' => now()
        ]);
    }
}