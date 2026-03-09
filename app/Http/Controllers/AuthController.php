<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect(route('panel.dashboard'));
        }

        return view('pages.auth.signin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => "required",
            'password' => "required",
        ]);

        $ok = Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], remember: true);

        if (!$ok) {
            return redirect()->back()->withErrors(['root' => 'Email dan password tidak ditemukan.'])->withInput();
        }

        return redirect(route('panel.dashboard'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect("");
    }
}
