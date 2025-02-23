<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileAdminController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
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
}
