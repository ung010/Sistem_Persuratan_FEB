<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{

    public function index()
    {
        return view('mahasiswa.index');
    }

    function edit($id)
    {
        $user = User::findOrFail($id);
        return view('mahasiswa.account', compact('user'));
    }

    function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users,nmr_unik,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'kota' => 'required',
            'tanggal_lahir' => 'required',
            'nowa' => 'required',
            'nama_ibu' => 'required',
            'almt_asl' => 'required',
            'dpt_id' => 'required',
            'prd_id' => 'required',
            'jnjg_id' => 'required',
            // 'password' => 'required|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            // 'password.required' => 'Password wajib diisi',
            // 'password.min' => 'Password minimal 8 karakter',
            'kota.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'nowa.required' => 'No handphone wajib diisi',
            'almt_asl.required' => 'Alamat asal rumah wajib diisi',
            'dpt_id.required' => 'Departemen wajib diisi',
            'prd_id.required' => 'Prodi wajib diisi',
            'jnjg_id.required' => 'Jenjang pendidikan wajib diisi',
        ]);

        $user->nama = $request->nama;
        $user->nmr_unik = $request->nmr_unik;
        $user->email = $request->email;
        $user->kota = $request->kota;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->nowa = $request->nowa;
        $user->almt_asl = $request->almt_asl;
        $user->jnjg_id = $request->jnjg_id;
        $user->dpt_id = $request->dpt_id;
        $user->prd_id = $request->prd_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
        return redirect()->route('mahasiswa.index')->with('success', 'Berhasil mengupdate data diri');

    }

    // DB::update('UPDATE kp SET name = :name, nim = :nim, bidang_id = :bidang_id,
        // tahun = :tahun, judul = :judul, perusahaan = :perusahaan, lokasi_perusahaan = :lokasi_perusahaan,
        // dosen_id = :dosen_id, abstrak = :abstrak, file = :file WHERE id_kp = :id',
        // [
        //     'id' => $id,
        //     'name' => $request->name,
        //     'nim' => $request->nim,
        //     'bidang_id' => $request->bidang_id,
        //     'tahun' => $request->tahun,
        //     'judul' => $request->judul,
        //     'perusahaan' => $request->perusahaan,
        //     'lokasi_perusahaan' => $request->lokasi_perusahaan,
        //     'dosen_id' => $request->dosen_id,
        //     'abstrak' => $request->abstrak,
        //     'file' => $nama_file,
        // ]
        // );

    // public function account()
    // {
    //     $user = Auth::user();
    //     $id = $user->id; // Pastikan kamu mendapatkan ID dari user yang terautentikasi

    //     $user = DB::table('users')
    //         ->join('prodi', 'users.prd_id', '=', 'prodi.id')
    //         ->join('departement', 'users.dpt_id', '=', 'departement.id')
    //         ->where('users.id', $id)
    //         ->select(
    //             'users.id',
    //             'prodi.id as prodi_id',
    //             'departement.id as departement_id',
    //             'users.nama',
    //             'users.nmr_unik',
    //             DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
    //             'users.nowa',
    //             'users.email',
    //             'users.almt_asl',
    //             'prodi.nama_prd',
    //             'departement.nama_dpt'
    //         )
    //         ->first();

    //     return view('mahasiswa.account', compact('user'));
    // }
}
