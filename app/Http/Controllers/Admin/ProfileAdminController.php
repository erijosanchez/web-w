<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Http\Requests\Admin\UpdateProfilePhotoRequest;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileAdminController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        //Muestra el rol
        $rol = AdminUser::find($admin->id)->roles()->first();
        return view('admin.profile.index', compact('admin', 'rol'));
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $admin->update($request->validated());

        return back()->with('status', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('status', 'Contraseña actualizada correctamente.');
    }

    /**Metodo para actualizar las fotos de perfil */

    public function updatePhoto(UpdateProfilePhotoRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        // Eliminar foto anterior si existe
        if ($admin->profile_photo_path) {
            Storage::disk('public')->delete($admin->profile_photo_path);
        }

        // Guardar nueva foto
        $path = $request->file('photo')->store('admin-photos', 'public');
        
        $admin->update([
            'profile_photo_path' => $path
        ]);

        return back()->with('status', 'Foto de perfil actualizada correctamente.');
    }

    public function destroyPhoto(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->profile_photo_path) {
            Storage::disk('public')->delete($admin->profile_photo_path);
            
            $admin->update([
                'profile_photo_path' => null
            ]);
        }

        return back()->with('status', 'Foto de perfil eliminada.');
    }
}
