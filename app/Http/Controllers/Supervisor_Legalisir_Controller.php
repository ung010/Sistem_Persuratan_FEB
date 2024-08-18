<?php

namespace App\Http\Controllers;

use App\Models\legalisir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Supervisor_Legalisir_Controller extends Controller
{
    function kirim_ijazah(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'ijazah')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_dikirim_ijazah', compact('data'));
    }

    function setuju_kirim_ijazah($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_dikirim_ijazah')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }

    function kirim_transkrip(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'transkrip')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_dikirim_transkrip', compact('data'));
    }

    function setuju_kirim_transkrip($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_dikirim_transkrip')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }

    function kirim_ijz_trs(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'ijazah_transkrip')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_dikirim_ijz_trs', compact('data'));
    }

    function setuju_kirim_ijz_trs($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_dikirim_ijz_trs')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }

    function ditempat_ijazah(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'ijazah')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_ditempat_ijazah', compact('data'));
    }

    function setuju_ditempat_ijazah($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_ditempat_ijazah')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }

    function ditempat_transkrip(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'transkrip')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_ditempat_transkrip', compact('data'));
    }

    function setuju_ditempat_transkrip($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_ditempat_transkrip')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }

    function ditempat_ijz_trs(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_akd')
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'ijazah_transkrip')
            ->select(
                'users.nmr_unik',
                'legalisir.id',
                'legalisir.nama_mhw',
                'legalisir.keperluan',
                'prodi.nama_prd',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'LIKE', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$search}%")
                    ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
            });
        }

        $data = $query->get();

        return view('legalisir_sv.sv_ditempat_ijz_trs', compact('data'));
    }

    function setuju_ditempat_ijz_trs($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'manajer';

        $legalisir->save();
        return redirect()->route('legalisir_sv.sv_ditempat_ijz_trs')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke manajer');
    }
}
