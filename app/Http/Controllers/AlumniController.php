<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    public function index()
    {
        return view('alumni.index');
    }

    public function account()
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

        return view('alumni.account', compact('user'));
    }

    
}
