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
}
