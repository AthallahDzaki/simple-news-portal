<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Auth;

class MainController extends Controller
{
    public function index()
    {
        $content = News::all();
        return view('beranda', ['content' => $content]);
    }

    public function login()
    {
        return view('login');
    }

    public function handleLogin(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // regenerasi session untuk keamanan

            // Redirect ke halaman sesuai role atau dashboard
            return redirect()->intended('/admin'); 
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}
