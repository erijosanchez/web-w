<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminUsers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileAdminController extends Controller
{
    public function index():View
    {
        return view('admin.profile.index');
    }

    public function update_profile(Request $request):RedirectResponse
    {
        $admin = auth()->user();
        
        $request->validate([
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,' . $admin->id . '|max:255',
            'phone' => 'required|string|max:12'
        ]);

        if ($request->hasFile('profile_img')) {
            // Verificar si existe una foto anterior
            if (!empty($admin->profile_img) && Storage::disk('public')->exists($admin->profile_img)) {
                // Intentar eliminar la foto anterior
                if (!Storage::disk('public')->delete($admin->profile_img)) {
                    return redirect()->back()->with('error', 'No se pudo eliminar la foto anterior. Intente nuevamente.');
                }
            }
        
            // Guardar la nueva foto
            try {
                $imagePath = $request->file('profile_img')->store('profile-photos', 'public');
                $admin->profile_img = $imagePath;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'No se pudo guardar la nueva imagen. Error: ' . $e->getMessage());
            }
        }

        // Crear username a partir del nombre y apellido
        $username = strtolower($request->first_name . '.' . $request->last_name);
        // Eliminar acentos, espacios y caracteres especiales
        $username = preg_replace('([^A-Za-z0-9.])', '', $this->removeAccents($username));
        // Verificar si el username ya existe y agregar número si es necesario
        $baseUsername = $username;
        $counter = 1;

        while (AdminUsers::where('username', $username)
            ->where('id', '!=', $admin->id)
            ->exists()
        ) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $admin->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $username,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_img' => $admin->profile_img,
        ]);

        return redirect()->back()->with('success', 'Administrador actualizado exitosamente');
    }

    private function removeAccents($string)
    {
        return strtr(utf8_decode($string), utf8_decode('áéíóúÁÉÍÓÚñÑ'), 'aeiouAEIOUnN');
    }
}
