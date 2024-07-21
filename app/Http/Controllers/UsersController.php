<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function users(){
        if (Auth::user()->role == 'mahasiswa'){
            return redirect('/mahasiswa')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'admin') {
            return redirect('/admin')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'alumni') {
            return redirect('/alumni')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'supervisor_akd') {
            return redirect('/supervisor_akd')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'supervisor_sd') {
            return redirect('/supervisor_sd')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'manajer') {
            return redirect('/manajer')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'non_mahasiswa') {
            return redirect('/non_mhw')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'non_alumni') {
            return redirect('/non_alum')->withErrors('Anda tidak punya akses');
        }
    }

    function home() {
        return view('auth.home');
    }
}
