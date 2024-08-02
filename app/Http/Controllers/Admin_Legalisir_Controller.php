<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\legalisir;
use App\Models\prodi;

class Admin_Legalisir_Controller extends Controller
{
    function kirim_ijazah(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_pmhn_kmbali_biaya.admin', compact('data'));
    }

    function unduh_kirim_ijazah($id)
    {
        $srt_pmhn_kmbali_biaya = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_pmhn_kmbali_biaya.id', $id)
            ->select(
                'srt_pmhn_kmbali_biaya.id',
                'srt_pmhn_kmbali_biaya.no_surat',
                'srt_pmhn_kmbali_biaya.tanggal_surat',
                'srt_pmhn_kmbali_biaya.nama_mhw',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.email',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_pmhn_kmbali_biaya.role_surat',
            )
            ->first();

        if (!$srt_pmhn_kmbali_biaya) {
            return redirect()->back()->with('error', 'Data not found');
        }

        if ($srt_pmhn_kmbali_biaya->tanggal_surat) {
            $srt_pmhn_kmbali_biaya->tanggal_surat = Carbon::parse($srt_pmhn_kmbali_biaya->tanggal_surat)->format('d-m-Y');
        }

        $qrUrl = url('/legal/srt_pmhn_kmbali_biaya/' . $srt_pmhn_kmbali_biaya->id);
        $qrCodePath = 'storage/qrcodes/qr-' . $srt_pmhn_kmbali_biaya->id . '.png';
        $qrCodeFullPath = public_path($qrCodePath);

        if (!File::exists(dirname($qrCodeFullPath))) {
            File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
        }

        QrCode::format('png')->size(100)->generate($qrUrl, $qrCodeFullPath);

        $mpdf = new Mpdf();
        $html = View::make('srt_pmhn_kmbali_biaya.view', compact('srt_pmhn_kmbali_biaya', 'qrCodePath'))->render();
        $mpdf->WriteHTML($html);

        $namaMahasiswa = $srt_pmhn_kmbali_biaya->nama;
        $tanggalSurat = Carbon::now()->format('Y-m-d');
        $fileName = 'Surat_Permohonan_Pengembalian_Biaya_' . str_replace(' ', '_', $namaMahasiswa) . '_' . $tanggalSurat . '.pdf';
        $mpdf->Output($fileName, 'D');
    }

    function cek_kirim_ijazah($id)
    {
        $srt_pmhn_kmbali_biaya = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_pmhn_kmbali_biaya.id', $id)
            ->select(
                'srt_pmhn_kmbali_biaya.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'users.foto',
                'users.email',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'srt_pmhn_kmbali_biaya.skl',
                'srt_pmhn_kmbali_biaya.bukti_bayar',
                'srt_pmhn_kmbali_biaya.buku_tabung',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_pmhn_kmbali_biaya.role_surat',
            )
            ->first();
        return view('srt_pmhn_kmbali_biaya.cek_data', compact('srt_pmhn_kmbali_biaya'));
    }

    function setuju_kirim_ijazah(Request $request, $id)
    {
        $srt_pmhn_kmbali_biaya = legalisir::where('id', $id)->first();

        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'No surat wajib diisi',
        ]);

        $srt_pmhn_kmbali_biaya->no_surat = $request->no_surat;
        $srt_pmhn_kmbali_biaya->role_surat = 'supervisor_akd';

        $srt_pmhn_kmbali_biaya->save();
        return redirect()->route('srt_pmhn_kmbali_biaya.admin')->with('success', 'No surat berhasil ditambahkan');
    }

    function tolak_kirim_ijazah(Request $request, $id)
    {
        $srt_pmhn_kmbali_biaya = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $srt_pmhn_kmbali_biaya->catatan_surat = $request->catatan_surat;
        $srt_pmhn_kmbali_biaya->role_surat = 'tolak';

        $srt_pmhn_kmbali_biaya->save();
        return redirect()->route('srt_pmhn_kmbali_biaya.admin')->with('success', 'Alasan penolakan telah dikirimkan');
    }
}
