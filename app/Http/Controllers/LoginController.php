<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index() {
        return view('auth.login');
    }

    function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if(Auth::attempt($infologin)){

            if (Auth::user()->role == 'mahasiswa'){
                return redirect('/mahasiswa');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role == 'supervisor') {
                return redirect('/supervisor');
            } elseif (Auth::user()->role == 'wakildekan') {
                return redirect('/wakildekan');
            } elseif (Auth::user()->role == '-') {
                return redirect('/akses_ditolak');
            }

        }else{
            return redirect('/')->withErrors('Penulisan email dan password ada kesalahan')->withInput();
        };
    }

    function logout() {
        Auth::logout();
        return redirect('');
    }
}
