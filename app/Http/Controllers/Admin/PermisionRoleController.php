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
        $admin = Auth::guard('admin')->user();
        return view('admin.roles.indexCreate', compact('permissions', 'admin'));
    }

    public function edit($name)
    {
        $roles = Roles::with('permissions')->where('name', $name)->firstOrFail();
        $permissions = Permission::all();
        $admin = Auth::guard('admin')->user();
        $rolePermissions = $roles->permissions->pluck('name')->toArray(); 
        return view('admin.roles.indexEdit', compact('roles', 'admin', 'permissions', 'rolePermissions'));
    }

    //funcion que procesa la creación de un nuevo rol 
    public function store(Request $request)
    {
        $role = Roles::create($request->only('name', 'description'));
        $role->permissions()->sync($request->input('permissions', []));
        return redirect()->route('admin.roles')->with('success', 'Rol creado exitosamente.');
    }

    //funcion que procesa la actualización de roles 
    public function update(Request $request, $name)
    {
        $role = Roles::with('permissions')->where('name', $name)->firstOrFail();
        $role->update($request->only('name', 'description'));
        $role->permissions()->sync($request->input('permissions', []));
        return redirect()->route('admin.roles')->with('success', 'Rol actualizado exitosament');
    }

    //funcion para eliminar los roles
    public function delete($name)
    {
        $role = Roles::where('name', $name)->firstOrFail();
        // Eliminar las relaciones con los permisos
        $role->permissions()->detach();
        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Rol eliminado correctamente');
    }

    /**FUNCIONES PARA EL MANEJO DE LOS PERMISOS */
    public function indexPermission()
    {
        $permissions = Permission::all();
        $admin = Auth::guard('admin')->user();
        return view('admin.permisos.index', compact('permissions', 'admin'));
    }

    //funcion para editar los permisos
    public function permissionEdit($name)
    {
        $permission = Permission::where('name', $name)->firstOrFail();
        return view('admin.permisos.indexEdit', compact('permission'));
    }

    //funcion que procesa la edicion de los permisos
    public function permissionUpdate(Request $request, $name)
    {
        $permission = Permission::where('name', $name)->firstOrFail();
        $permission->update($request->only('name', 'description'));
        return redirect()->route('admin.permission')->with('success', 'Permiso actualizado exit');
    }

    //funcion para eliminar los permisos
    public function permissionDelete ($name) 
    {
        $permission = Permission::where('name', $name)->firstOrFail();
        $permission->delete();
        return redirect()->route('admin.permission')->with('success', 'Permiso eliminado correctamente');  
    }
}
