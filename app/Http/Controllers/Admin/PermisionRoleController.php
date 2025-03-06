<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;

class PermisionRoleController extends Controller
{
    public function index()
    {
        $roles = Roles::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    //muestra la vista de creacion de rol
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.indexCreate', compact('permissions'));
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
