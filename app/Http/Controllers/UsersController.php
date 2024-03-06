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
        } elseif (Auth::user()->role == 'supervisor') {
            return redirect('/supervisor')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'wakildekan') {
            return redirect('/wakildekan')->withErrors('Anda tidak punya akses');
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
