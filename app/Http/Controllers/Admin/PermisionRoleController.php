<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermisionRoleController extends Controller
{
    public function index()
    {
        $roles = Roles::with('permissions')->get();
        $admin = Auth::guard('admin')->user();
        return view('admin.roles.index', compact('roles', 'admin'));
    }

    //muestra la vista de creacion de rol
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.indexCreate', compact('permissions'));
    }

    public function edit($name)
    {
        $roles = Roles::with('permissions')->where('name', $name)->firstOrFail();
        $admin = Auth::guard('admin')->user();
        return view('admin.roles.indexEdit', compact('roles', 'admin'));
    }

    //funcion que procesa la creación de un nuevo rol 
    public function store(Request $request)
    {
        $role = Roles::create($request->only('name', 'description'));
        $role->permissions()->sync($request->input('permissions', []));
        return redirect()->route('admin.roles')->with('success', 'Rol creado exitosamente.');
    }

    //funcion para eliminar los roles
    public function delete(Roles $role)
    {
        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Rol eliminado.');
    }
}
