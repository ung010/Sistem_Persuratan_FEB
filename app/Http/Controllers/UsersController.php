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
        } elseif (Auth::user()->role == 'supervisor') {
            return redirect('/supervisor')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'wakildekan') {
            return redirect('/wakildekan')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'non_mahasiswa') {
            return redirect('/non_mhw')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'non_alumni') {
            return redirect('/non_alum')->withErrors('Anda tidak punya akses');
        }
    }

    function home() {
        return view('auth.home');
    }

    function supervisor(){
        return view('supervisor.index');
    }

    function wadek(){
        return view('wakil_dekan.index');
    }
}
