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
        Session::flash('nmr_unik', $request->input('nmr_unik'));
        Session::flash('email', $request->input('email'));
        Session::flash('kota', $request->input('kota'));
        Session::flash('tanggal_lahir', $request->input('tanggal_lahir'));
        Session::flash('nowa', $request->input('nowa'));
        Session::flash('role', $request->input('role'));
        Session::flash('almt_asl', $request->input('almt_asl'));
        Session::flash('almt_smg', $request->input('almt_smg'));

        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'kota' => 'required',
            'tanggal_lahir' => 'required',
            'nowa' => 'required',
            'role' => 'required',
            'almt_asl' => 'required',
            'almt_smg' => 'required',
            'password' => 'required|min:8',
            'foto' => 'required|mimes:jpeg,jpg,png'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'kota.required' => 'Kota lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'role.required' => 'Wajib mengisi pilihan mahasiswa / alumni',
            'nowa.required' => 'No handphone wajib diisi',
            'almt_asl.required' => 'Alamat asal rumah wajib diisi',
            'almt_smg.required' => 'Alamat di Semarang wajib diisi',
            'foto.required' => 'Foto wajib diisi',
            'foto.mimes' => 'Foto wajib berbentuk JPEG, JPG, dan PNG',
        ]);

        $foto = $request->file('foto');
        $foto_extensi = $foto->extension();
        $nama_foto = date('ymdhis') . '.' . $foto_extensi;
        $foto->move(public_path('storage/foto/mahasiswa'), $nama_foto);

        $data = [
            'nama' => $request->nama,
            'nmr_unik' => $request->nmr_unik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kota' => $request->kota,
            'tanggal_lahir' => $request->tanggal_lahir,
            'role' => $request->role,
            'nowa' => $request->nowa,
            'almt_asl' => $request->almt_asl,
            'almt_smg' => $request->almt_smg,
            'dpt_id' => $request->dpt_id,
            'prd_id' => $request->prd_id,
            'foto' => $nama_foto
        ];
        User::create($data);

        $inforegister = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // dibenerin dulu logika role mahasiswa dan alumni non approve
        if (Auth::attempt($inforegister)) {
            $user = Auth::user();
    
            // Pengecekan role dan pengalihan ke halaman yang sesuai
            if ($user->role == 'non_mahasiswa') {
                return redirect('/non_mhw');
            } elseif ($user->role == 'non_alumni') {
                return redirect('/non_alum');
            } else {
                return redirect('/error_register');
            }
        } else {
            return redirect('/register')->withErrors('Email, password, atau data lain yang dimasukkan tidak sesuai');
        }
    }
}
