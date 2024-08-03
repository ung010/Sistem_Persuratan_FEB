<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\legalisir;
use ZipStream\ZipStream;
use Illuminate\Support\Facades\Response;

class Admin_Legalisir_Controller extends Controller
{
    function kirim_ijazah(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'ijazah');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_dikirim_ijazah', compact('data'));
    }

    public function unduh_kirim_ijazah($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'ijazah')
            ->where('ambil', 'dikirim')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $filePath = public_path('storage/pdf/legalisir/ijazah/' . $legalisir->file_ijazah);
        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        return response()->download($filePath, $legalisir->file_ijazah);
    }

    function cek_kirim_ijazah($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_dikirim_ijazah', compact('legalisir'));
    }

    function setuju_kirim_ijazah($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_ijazah')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_kirim_ijazah(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_ijazah')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_kirim_ijazah(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_dikirim_ijazah')->with('success', 'Informasi pengiriman telah diperbarui.');
    }

    function kirim_transkrip(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'transkrip');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_dikirim_transkrip', compact('data'));
    }

    public function unduh_kirim_transkrip($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'transkrip')
            ->where('ambil', 'dikirim')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $filePath = public_path('storage/pdf/legalisir/transkrip/' . $legalisir->file_transkrip);
        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        return response()->download($filePath, $legalisir->file_transkrip);
    }

    function cek_kirim_transkrip($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_dikirim_transkrip', compact('legalisir'));
    }

    function setuju_kirim_transkrip($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_transkrip')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_kirim_transkrip(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_transkrip')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_kirim_transkrip(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_dikirim_transkrip')->with('success', 'Informasi pengiriman telah diperbarui.');
    }

    function kirim_ijz_trs(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'dikirim')
            ->where('jenis_lgl', 'ijazah_transkrip');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_dikirim_ijz_trs', compact('data'));
    }

    public function unduh_kirim_ijz_trs($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'ijazah_transkrip')
            ->where('ambil', 'dikirim')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $fileIjazahPath = public_path('storage/pdf/legalisir/ijazah/' . $legalisir->file_ijazah);
        $fileTranskripPath = public_path('storage/pdf/legalisir/transkrip/' . $legalisir->file_transkrip);

        if (!file_exists($fileIjazahPath) || !file_exists($fileTranskripPath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        $zipFileName = 'files.zip';
        $zip = new \ZipArchive();
        $zipPath = storage_path('app/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            return redirect()->back()->withErrors('Gagal membuat file ZIP.');
        }

        $zip->addFile($fileIjazahPath, 'ijazah.pdf');
        $zip->addFile($fileTranskripPath, 'transkrip.pdf');

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    function cek_kirim_ijz_trs($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_dikirim_ijz_trs', compact('legalisir'));
    }

    function setuju_kirim_ijz_trs($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_ijz_trs')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_kirim_ijz_trs(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_dikirim_ijz_trs')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_kirim_ijz_trs(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_dikirim_ijz_trs')->with('success', 'Informasi pengiriman telah diperbarui.');
    }

    function ditempat_ijazah(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'ijazah');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_ditempat_ijazah', compact('data'));
    }

    public function unduh_ditempat_ijazah($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'ijazah')
            ->where('ambil', 'ditempat')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $filePath = public_path('storage/pdf/legalisir/ijazah/' . $legalisir->file_ijazah);
        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        return response()->download($filePath, $legalisir->file_ijazah);
    }

    function cek_ditempat_ijazah($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_ditempat_ijazah', compact('legalisir'));
    }

    function setuju_ditempat_ijazah($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_ijazah')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_ditempat_ijazah(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_ijazah')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_ditempat_ijazah(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_ditempat_ijazah')->with('success', 'Informasi pengiriman telah diperbarui.');
    }

    function ditempat_transkrip(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'transkrip');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_ditempat_transkrip', compact('data'));
    }

    public function unduh_ditempat_transkrip($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'transkrip')
            ->where('ambil', 'ditempat')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $filePath = public_path('storage/pdf/legalisir/transkrip/' . $legalisir->file_transkrip);
        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        return response()->download($filePath, $legalisir->file_transkrip);
    }

    function cek_ditempat_transkrip($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_ditempat_transkrip', compact('legalisir'));
    }

    function setuju_ditempat_transkrip($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_transkrip')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_ditempat_transkrip(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_transkrip')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_ditempat_transkrip(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_ditempat_transkrip')->with('success', 'Informasi pengiriman telah diperbarui.');
    }

    function ditempat_ijz_trs(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('ambil', 'ditempat')
            ->where('jenis_lgl', 'ijazah_transkrip');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('legalisir_admin.admin_ditempat_ijz_trs', compact('data'));
    }

    public function unduh_ditempat_ijz_trs($id)
    {
        $legalisir = DB::table('legalisir')
            ->where('id', $id)
            ->where('jenis_lgl', 'ijazah_transkrip')
            ->where('ambil', 'ditempat')
            ->first();

        if (!$legalisir) {
            return redirect()->back()->withErrors('Data tidak ditemukan atau tidak valid.');
        }

        $fileIjazahPath = public_path('storage/pdf/legalisir/ijazah/' . $legalisir->file_ijazah);
        $fileTranskripPath = public_path('storage/pdf/legalisir/transkrip/' . $legalisir->file_transkrip);

        if (!file_exists($fileIjazahPath) || !file_exists($fileTranskripPath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }

        $zipFileName = 'files.zip';
        $zip = new \ZipArchive();
        $zipPath = storage_path('app/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            return redirect()->back()->withErrors('Gagal membuat file ZIP.');
        }

        $zip->addFile($fileIjazahPath, 'ijazah.pdf');
        $zip->addFile($fileTranskripPath, 'transkrip.pdf');

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    function cek_ditempat_ijz_trs($id)
    {
        $legalisir = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('legalisir.id', $id)
            ->select(
                'legalisir.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'legalisir.no_resi',
                'legalisir.ambil',
                'legalisir.jenis_lgl',
                'legalisir.keperluan',
                'legalisir.tgl_lulus',
                'legalisir.almt_kirim',
                'legalisir.kcmt_kirim',
                'legalisir.kdps_kirim',
                'legalisir.klh_kirim',
                'legalisir.kota_kirim',
                'legalisir.file_ijazah',
                'legalisir.file_transkrip',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'legalisir.role_surat',
            )
            ->first();
        return view('legalisir_admin.cek_ditempat_ijz_trs', compact('legalisir'));
    }

    function setuju_ditempat_ijz_trs($id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $legalisir->role_surat = 'supervisor_akd';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_ijz_trs')->with('success', 'Legalisir berhasil disetujui dan dilanjutkan ke supervisor akademik');
    }

    function tolak_ditempat_ijz_trs(Request $request, $id)
    {
        $legalisir = legalisir::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $legalisir->catatan_surat = $request->catatan_surat;
        $legalisir->role_surat = 'tolak';

        $legalisir->save();
        return redirect()->route('legalisir_admin.admin_ditempat_ijz_trs')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    public function resi_ditempat_ijz_trs(Request $request, $id)
    {
        $legalisir = legalisir::findOrFail($id);

        $isDiambilDitempat = $request->has('diambil_ditempat');

        if (!$isDiambilDitempat) {
            $request->validate([
                'no_resi' => 'required',
            ], [
                'no_resi.required' => 'No resi wajib diisi',
            ]);
        }

        $legalisir->no_resi = $isDiambilDitempat ? 'Diambil Ditempat' : $request->no_resi;
        $legalisir->role_surat = 'mahasiswa';

        $legalisir->save();

        return redirect()->route('legalisir_admin.admin_ditempat_ijz_trs')->with('success', 'Informasi pengiriman telah diperbarui.');
    }
}
