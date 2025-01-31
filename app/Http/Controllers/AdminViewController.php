<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewController extends Controller
{
    public function sensitivePage()
    {
        // Comprobación si el usuario logeado tiene el rol Admin
        if (!Auth::check() || !Auth::user()->hasRole('Admin')) {
            abort(403, 'Acceso denegado. No tiene los permisos para ver esta página');
        }

        return view('add-teachers');
    }
}

