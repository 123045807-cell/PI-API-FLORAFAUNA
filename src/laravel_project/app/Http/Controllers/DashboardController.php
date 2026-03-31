<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $alumno = Auth::guard('alumno')->user();
        return view('dashboard', compact('alumno'));
    }
}
