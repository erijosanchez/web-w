<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminRole;

class AdminsController extends Controller
{
    public function createAdminIndex()
    {
        // Se optinen todos los roles disponibles
        $roles = AdminRole::all();
        return view('admin.admins.createindex', compact('roles'));
    }

    public function saindex()
    {

        $admins = AdminUsers::where('role_id', 4)->latest()->get();
        return view('admin.admins.superAdminsIndex', compact('admins'));
    }

    public function adminindex()
    {
        $admins = AdminUsers::where('role_id', 5)->latest()->get();
        return view('admin.admins.adminIndex', compact('admins'));
    }

    public function supervisorindex()
    {
        $admins = AdminUsers::where('role_id', 6)->latest()->get();
        return view('admin.admins.SRIndex', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin_users'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'exists:admin_roles,id'],
            'password' => [
                'required',
                'confirmed',
            ],
        ]);

        try {
            DB::beginTransaction();

            // Create admin user
            $admin = AdminUsers::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role_id' => $validated['role'],
                'password' => Hash::make($validated['password']),
                'username' => strtolower($validated['first_name'] . '.' . $validated['last_name']),
                'is_active' => true,
            ]);

            DB::commit();

            // Log the creation
            Log::info('New admin created', [
                'admin_id' => $admin->id,
                'created_by' => Auth::id()
            ]);

            return redirect()
                ->route('admin.admins.index')
                ->with('success', 'Administrador creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating admin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el administrador. Por favor, intente nuevamente.');
        }
    }

    public function update(Request $request, AdminUsers $admin)
    {
        return redirect()->back()->with('success', 'hola');
    }

    public function destroy(AdminUsers $admin)
    {
        $admin->delete();
        return redirect()->back()->with('success', 'Administrador eliminado exitosamente');
    }
}
