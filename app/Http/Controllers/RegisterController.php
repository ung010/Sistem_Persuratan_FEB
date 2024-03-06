<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
        Session::flash('almt_asl', $request->input('almt_asl'));
        Session::flash('almt_smg', $request->input('almt_smg'));
        // Session::flash('dpt_id', $request->input('dpt_id'));
        // Session::flash('prd_id', $request->input('prd_id'));

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'ttl' => 'required',
            'nowa' => 'required',
            'almt_asl' => 'required',
            'almt_smg' => 'required',
            'password' => 'required|min:8',
            'foto' => 'required|mimes:jpeg,jpg,png'
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'ttl.required' => 'Tempat, Tanggal Lahir wajib diisi',
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
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ttl' => $request->ttl,
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

        if (Auth::attempt($inforegister)) {
            return redirect('/mahasiswa')->with('success Berhasil Register Akun');
        } else {
            return redirect('/register')->withErrors('Email, password, atau data lain yang dimasukkan tidak sesuai');
        }
    }

    function delete($id) {
        $data =  User::where('id', $id)->first();
        File::delete(public_path('storage/foto/mahasiswa'). '/' . $data->foto);
        User::where('id', $id)->delete();
        return redirect ('/admin/akun_user')->with('success', 'Sukses Menghapus');
    }
}
