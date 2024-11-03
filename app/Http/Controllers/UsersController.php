<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function users(){
        if (Auth::user()->role == 'mahasiswa'){
            return redirect('/user')->with('success', 'Permintaan sudah disetujui, silahkan menggunakan fasilitas website ini');
        } elseif (Auth::user()->role == 'admin') {
            return redirect('/admin')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'supervisor_akd') {
            return redirect('/supervisor_akd')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'supervisor_sd') {
            return redirect('/supervisor_sd')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'manajer') {
            return redirect('/manajer')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'wd1') {
            return redirect('/manajer')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'wd2') {
            return redirect('/manajer')->withErrors('Anda tidak punya akses');
        } elseif (Auth::user()->role == 'non_mahasiswa') {
            return redirect('/non_user')->withErrors('Akun masih belum dicek atau diterima oleh admin, minta admin untuk melakukan approve');
        } elseif (Auth::user()->role == 'del_mahasiswa') {
            return redirect('/del_user')->withErrors('Akun anda telah di suspend oleh admin, minta ke admin untuk mengembalikan akun anda');
        }
    }

    function home() {
        return view('auth.home');
    }
}
