<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index ()
    {
        $admin = Auth::guard('admin')->user(); /**consulta para obtener los datos del adminustrador que se encuentra logeado */
        
        return view('admin.dashboard.dashboard', compact('admin'));
    }
}
