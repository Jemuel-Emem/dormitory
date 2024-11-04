<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class logout extends Controller
{
    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
}
