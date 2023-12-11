<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{

    public function index()
    {
        return view('mahasiswa.index');
    }

    public function account()
    {

        // $user = Auth::user();
        // return view('mahasiswa.account', compact('user'));

        $user = Auth::user();

        // Lakukan join dengan tabel 'prodi' dan 'departemen'
        $user = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->where('users.id', $user->id)
            ->select('users.id', 'prodi.id', 'departement.id', 'users.nama', 'users.nim', 'users.ttl', 'users.nowa',
            'users.email', 'users.ttl', 'users.almt_asl', 'users.almt_smg', 'prodi.nama_prd', 'departement.nama_dpt')
            ->first();

        return view('mahasiswa.account', compact('user'));

        // $joins = DB::table('users')
        // ->join('dosen', 'kp.dosen_id', '=', 'dosen.id')
        // ->join('bidang', 'kp.bidang_id', '=', 'bidang.id')
        // ->select('kp.id_kp', 'kp.name', 'kp.nim', 'bidang.nama_bidang', 'kp.tahun', 'kp.judul',
        // 'kp.perusahaan', 'kp.lokasi_perusahaan', 'dosen.nama_dosen', 'kp.abstrak', 'kp.file');

        // $joins = DB::table('join')
        // ->join('gunpla', 'join.id_gunpla', '=', 'gunpla.id_gunpla')
        // ->join('pembeli', 'join.id_pembeli', '=', 'pembeli.id_pembeli')
        // ->join('gudang', 'join.id_gudang', '=', 'gudang.id_gudang')
        // ->orderBy('nama_pembeli')
        // ->select('gudang.kota_gudang', 'gunpla.nama_gunpla', 'pembeli.nama_pembeli', 'pembeli.alamat_pembeli')
        // ->get();

    }
}
