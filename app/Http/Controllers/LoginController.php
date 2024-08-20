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
                return redirect('/user');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role == 'supervisor_akd') {
                return redirect('/supervisor_akd');
            } elseif (Auth::user()->role == 'supervisor_sd') {
                return redirect('/supervisor_sd');
            } elseif (Auth::user()->role == 'manajer') {
                return redirect('/manajer');
            } elseif (Auth::user()->role == 'non_mahasiswa') {
                return redirect('/non_user');
            } elseif (Auth::user()->role == 'del_mahasiswa') {
                return redirect('/del_user');
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
