<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function users(){
        // echo "halo, selamat datang";
        // echo "<h1>" . Auth::user()->nama . "<h1>";
        // echo "<a href='/logout'>Logout</a>";

        if (Auth::user()->role == 'mahasiswa'){
            return redirect('/users/mahasiswa')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'admin') {
            return redirect('/users/admin')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'supervisor') {
            return redirect('/users/supervisor')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'wakildekan') {
            return redirect('/users/wakildekan')->withErrors('Anda tidak punya akses');
        }
    }

    function mahasiswa(){
        
        return view('mahasiswa.index');
    }

    function admin(){
        return view('admin.index');
    }

    function supervisor(){
        return view('supervisor.index');
    }

    function wadek(){
        return view('wakil_dekan.index');
    }
}
