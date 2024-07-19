<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NonController extends Controller
{
    function home_non_mhw() {
        return view('non_mhw.home');
    }

    public function account_non_mhw()
    {
        $user = Auth::user();
        $id = $user->id; // Pastikan kamu mendapatkan ID dari user yang terautentikasi

        $user = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->where('users.id', $id)
            ->select(
                'users.id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'users.nama',
                'users.nmr_unik',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'users.nowa',
                'users.email',
                'users.almt_asl',
                'users.almt_smg',
                'prodi.nama_prd',
                'departement.nama_dpt'
            )
            ->first();

            // dd($user);

        return view('non_mhw.account', compact('user'));
    }

    function home_non_alum() {
        return view('non_alum.home');
    }

    public function account_non_alum()
    {
        $user = Auth::user();
        $id = $user->id; // Pastikan kamu mendapatkan ID dari user yang terautentikasi

        $user = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->where('users.id', $id)
            ->select(
                'users.id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'users.nama',
                'users.nmr_unik',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'users.nowa',
                'users.email',
                'users.almt_asl',
                'users.almt_smg',
                'prodi.nama_prd',
                'departement.nama_dpt'
            )
            ->first();

            // dd($user);

        return view('non_alum.account', compact('user'));
    }
}
