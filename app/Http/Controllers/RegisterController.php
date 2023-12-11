<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    function register() {
        return view('auth.register');
    }

    function create(Request $request)
    {
        Session::flash('nama', $request->input('nama'));
        Session::flash('nim', $request->input('nim'));
        Session::flash('email', $request->input('email'));
        Session::flash('ttl', $request->input('ttl'));
        Session::flash('nowa', $request->input('nowa'));
        Session::flash('almt_smg', $request->input('almt_smg'));
        // Session::flash('dpt_id', $request->input('dpt_id'));
        // Session::flash('prd_id', $request->input('prd_id'));

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'ttl' => 'required',
            'nowa' => 'required',
            'almt_smg' => 'required',
            'password' => 'required|min:8'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'ttl.required' => 'Tempat, Tanggal Lahir wajib diisi',
            'nowa.required' => 'No Handphone wajib diisi',
            'almt_smg.required' => 'Alamat Tinggal di Semarang wajib diisi',
        ]);

        $data = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ttl' => $request->ttl,
            'nowa' => $request->nowa,
            'almt_asl' => $request->almt_asl,
            'almt_smg' => $request->almt_smg,
            'dpt_id' => $request->dpt_id,
            'prd_id' => $request->prd_id,
        ];
        User::create($data);

        $inforegister = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($inforegister)) {
            return redirect('/users/mahasiswa')->with('success Berhasil Register Akun');
        } else {
            return redirect('/register')->withErrors('Email, password, atau data lain yang dimasukkan tidak sesuai');
        }
    }
}
