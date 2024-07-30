<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Legal_Controller extends Controller
{
    function testing() {
        $srt_masih_mhw = DB::table('srt_masih_mhw')
            ->where('role_surat', 'mahasiswa')
            ->select(
                'nama_mhw'
            )
            ->paginate(5);
        
            return view('legal.testing', compact('srt_masih_mhw'));
    }

    function srt_masih_mhw($id) {
        $srt_masih_mhw = DB::table('srt_masih_mhw')
            ->join('prodi', 'srt_masih_mhw.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_masih_mhw.users_id', '=', 'users.id')
            ->join('departement', 'srt_masih_mhw.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_masih_mhw.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_masih_mhw.id', $id)
            ->select(
                'srt_masih_mhw.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'srt_masih_mhw.nama_mhw',
                'srt_masih_mhw.no_surat',
                'users.nmr_unik',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_masih_mhw.tujuan_buat_srt',
                'srt_masih_mhw.role_surat',
                'srt_masih_mhw.tujuan_akhir',
                'srt_masih_mhw.tanggal_surat'
            )
            ->first();

            if ($srt_masih_mhw) {
                $srt_masih_mhw->tanggal_surat = Carbon::parse($srt_masih_mhw->tanggal_surat)->format('d-m-Y');
            }

            return view('legal.srt_masih_mhw', compact('srt_masih_mhw'));
    }

    function lihat_srt_masih_mhw($id) {
        $srt_masih_mhw = DB::table('srt_masih_mhw')
            ->join('prodi', 'srt_masih_mhw.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_masih_mhw.users_id', '=', 'users.id')
            ->join('departement', 'srt_masih_mhw.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_masih_mhw.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_masih_mhw.id', $id)
            ->select(
                'srt_masih_mhw.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'srt_masih_mhw.nama_mhw',
                'users.nmr_unik',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'srt_masih_mhw.thn_awl',
                'srt_masih_mhw.thn_akh',
                'srt_masih_mhw.almt_smg',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'srt_masih_mhw.tujuan_buat_srt',
                'srt_masih_mhw.role_surat',
                'srt_masih_mhw.tujuan_akhir',
                'srt_masih_mhw.tanggal_surat'
            )
            ->first();

        if (!$srt_masih_mhw) {
            return redirect()->back()->with('error', 'Data not found');
        }

        if ($srt_masih_mhw->tanggal_surat) {
            $srt_masih_mhw->tanggal_surat = Carbon::parse($srt_masih_mhw->tanggal_surat)->format('d-m-Y');
        }

        $qrUrl = 'https://jagatplay.com/';
        $qrCodePath = 'storage/qrcodes/qr-' . $srt_masih_mhw->id . '.png';
        $qrCodeFullPath = public_path($qrCodePath);

        if (!File::exists(dirname($qrCodeFullPath))) {
            File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
        }

        QrCode::format('png')->size(200)->generate($qrUrl, $qrCodeFullPath);

        $mpdf = new Mpdf();
        $html = View::make('srt_masih_mhw.view_wd', compact('srt_masih_mhw', 'qrCodePath'))->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function srt_mhw_asn() {

    }
}
