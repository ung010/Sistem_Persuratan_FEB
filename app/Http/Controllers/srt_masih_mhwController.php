<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use App\Models\srt_masih_mhw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class srt_masih_mhwController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->join('prodi', 'srt_masih_mhw.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_masih_mhw.users_id', '=', 'users.id')
            ->join('departement', 'srt_masih_mhw.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_masih_mhw.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users_id', $user->id)
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
                'srt_masih_mhw.tujuan_akhir'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('almt_smg', 'like', "%{$search}%")
                    ->orWhere('thn_awl', 'like', "%{$search}%")
                    ->orWhere('thn_akh', 'like', "%{$search}%")
                    ->orWhere('tujuan_buat_srt', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();

        $kota = $user->kota;
        $tanggal_lahir = $user->tanggal_lahir;
        $kota_tanggal_lahir = ($kota && $tanggal_lahir) ? $kota . ', ' . \Carbon\Carbon::parse($tanggal_lahir)->format('d F Y') : 'N/A';

        return view('srt_masih_mhw.index', compact('data', 'user', 'jenjang', 'departemen', 'kota_tanggal_lahir'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'thn_awl' => 'required',
            'thn_akh' => 'required',
            'almt_smg' => 'required',
            'tujuan_buat_srt' => 'required',
            'tujuan_akhir' => 'required',
        ], [
            'thn_awl.required' => 'Tahun pertama wajib diisi',
            'thn_akh.required' => 'Tahun kedua wajib diisi',
            'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
            'tujuan_buat_srt.required' => 'Tujuan pembuatan surat wajib diisi',
            'tujuan_akhir.required' => 'Wajib memilih yang mendatangani surat',
        ]);

        $user = Auth::user();

        DB::table('srt_masih_mhw')->insert([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'thn_awl' => $request->thn_awl,
            'thn_akh' => $request->thn_akh,
            'almt_smg' => $request->almt_smg,
            'tujuan_buat_srt' => $request->tujuan_buat_srt,
            'tujuan_akhir' => $request->tujuan_akhir,
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('srt_masih_mhw.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('srt_masih_mhw')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('srt_masih_mhw.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();

        $kota = $user->kota;
        $tanggal_lahir = $user->tanggal_lahir;
        $kota_tanggal_lahir = ($kota && $tanggal_lahir) ? $kota . ', ' . \Carbon\Carbon::parse($tanggal_lahir)->format('d F Y') : 'N/A';

        return view('srt_masih_mhw.edit', compact('data', 'user', 'jenjang', 'departemen', 'kota_tanggal_lahir'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'thn_awl' => 'required',
            'thn_akh' => 'required',
            'almt_smg' => 'required',
            'tujuan_buat_srt' => 'required',
        ], [
            'thn_awl.required' => 'Tahun pertama wajib diisi',
            'thn_akh.required' => 'Tahun kedua wajib diisi',
            'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
            'tujuan_buat_srt.required' => 'Tujuan pembuatan surat wajib diisi',
        ]);

        DB::table('srt_masih_mhw')->where('id', $id)->update([
            'thn_awl' => $request->thn_awl,
            'thn_akh' => $request->thn_akh,
            'almt_smg' => $request->almt_smg,
            'tujuan_buat_srt' => $request->tujuan_buat_srt,
            'role_surat' => 'admin',
            'catatan_surat' => '-',
        ]);

        return redirect()->route('srt_masih_mhw.index')->with('success', 'Surat berhasil diperbarui');
    }

    function download_wd($id)
    {  
        $srt_masih_mhw = DB::table('srt_masih_mhw')
        ->join('users', 'srt_masih_mhw.users_id', '=', 'users.id')
        ->where('srt_masih_mhw.id', $id)
        ->select('srt_masih_mhw.file_pdf', 'users.nama')
        ->first();

        if (!$srt_masih_mhw || !$srt_masih_mhw->file_pdf) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = public_path('storage/pdf/srt_masih_mahasiswa/wd/' . $srt_masih_mhw->file_pdf);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $srt_masih_mhw->file_pdf);
    }

    function download_manajer($id)
    {  
        $mpdf = new \Mpdf\Mpdf();
        
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

            if ($srt_masih_mhw && $srt_masih_mhw->tanggal_surat) {
                $srt_masih_mhw->tanggal_surat = Carbon::parse($srt_masih_mhw->tanggal_surat)->format('d-m-Y');
            }

            $mpdf->writeHTML(view('srt_masih_mhw.view_manajer', compact('srt_masih_mhw')));
            $mpdf->Output('Surat-Masih-Mahasiswa.pdf', 'D');
    }

    function admin(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
            )
            ->where('role_surat', 'admin')
            ->where('tujuan_akhir', 'manajer');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_masih_mhw.admin', compact('data'));
    }

    function wd(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
                'tujuan_akhir'
            )
            ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
            ->where('tujuan_akhir', 'wd');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('role_surat', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_masih_mhw.wd', compact('data'));
    }

    function wd_unduh($id)
    {
        $mpdf = new \Mpdf\Mpdf();
        
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

            if ($srt_masih_mhw && $srt_masih_mhw->tanggal_surat) {
                $srt_masih_mhw->tanggal_surat = Carbon::parse($srt_masih_mhw->tanggal_surat)->format('d-m-Y');
            }

            $mpdf->writeHTML(view('srt_masih_mhw.view_wd', compact('srt_masih_mhw')));

            if ($srt_masih_mhw) {
                $namaMahasiswa = $srt_masih_mhw->nama;
                $tanggalSurat = \Carbon\Carbon::now()->format('Y-m-d');
                $fileName = 'Surat-Masih-Mahasiswa-' . str_replace(' ', '-', $namaMahasiswa) . '-' . $tanggalSurat . '.pdf';
                $mpdf->Output($fileName, 'D');
            } else {
                return redirect()->back()->with('error', 'data not found');
            }
    }

    public function wd_unggah(Request $request, $id) {
        $request->validate([
            'srt_masih_mhw' => 'required|mimes:pdf'
        ], [
            'srt_masih_mhw.required' => 'Surat wajib diisi',
            'srt_masih_mhw.mimes' => 'Surat wajib berbentuk / berekstensi PDF',
        ]);

        $srt_masih_mhw = DB::table('srt_masih_mhw')
            ->join('prodi', 'srt_masih_mhw.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_masih_mhw.users_id', '=', 'users.id')
            ->join('departement', 'srt_masih_mhw.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_masih_mhw.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_masih_mhw.id', $id)
            ->select(
                'srt_masih_mhw.id',
                'users.nama',
                'srt_masih_mhw.tanggal_surat'
            )
            ->first();

        if (!$srt_masih_mhw) {
            return redirect()->back()->withErrors('Data surat tidak ditemukan.');
        }

        $tanggal_surat = Carbon::parse($srt_masih_mhw->tanggal_surat)->format('d-m-Y');
        $nama_mahasiswa = Str::slug($srt_masih_mhw->nama);
        
        $file = $request->file('srt_masih_mhw');
        $surat_extensi = $file->extension();
        $nama_surat = "Surat_Masih_Mahasiswa_{$tanggal_surat}_{$nama_mahasiswa}." . $surat_extensi;
        $file->move(public_path('storage/pdf/srt_masih_mahasiswa/wd'), $nama_surat);

        srt_masih_mhw::where('id', $id)->update([
            'file_pdf' => $nama_surat,
            'role_surat' => 'mahasiswa',
        ]);

        return redirect()->back()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');
    }

    function wd_cek($id)
    {
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
                'users.nmr_unik',
                'users.almt_asl',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'users.nowa',
                'users.foto',
                'srt_masih_mhw.tujuan_buat_srt',
                'srt_masih_mhw.tujuan_akhir'
            )
            ->first();
        return view('srt_masih_mhw.wd_cek', compact('srt_masih_mhw'));
    }

    function wd_setuju(Request $request, $id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'No surat wajib diisi',
        ]);

        $srt_masih_mhw->no_surat = $request->no_surat;
        $srt_masih_mhw->role_surat = 'supervisor_akd';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.wd')->with('success', 'No surat berhasil ditambahkan');
    }

    function wd_tolak(Request $request, $id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $srt_masih_mhw->catatan_surat = $request->catatan_surat;
        $srt_masih_mhw->role_surat = 'tolak';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.wd')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    function cek_surat_admin($id)
    {
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
                'users.nmr_unik',
                'users.almt_asl',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'users.nowa',
                'users.foto',
                'srt_masih_mhw.tujuan_buat_srt',
                'srt_masih_mhw.tujuan_akhir'
            )
            ->first();
        return view('srt_masih_mhw.cek_data', compact('srt_masih_mhw'));
    }

    function setuju(Request $request, $id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'No surat wajib diisi',
        ]);

        $srt_masih_mhw->no_surat = $request->no_surat;
        $srt_masih_mhw->role_surat = 'supervisor_akd';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.admin')->with('success', 'No surat berhasil ditambahkan');
    }

    function tolak(Request $request, $id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $srt_masih_mhw->catatan_surat = $request->catatan_surat;
        $srt_masih_mhw->role_surat = 'tolak';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.admin')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    function supervisor(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'tujuan_buat_srt'
            )
            ->where('role_surat', 'supervisor_akd');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('tujuan_buat_srt', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_masih_mhw.supervisor', compact('data'));
    }

    function setuju_sv($id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $srt_masih_mhw->role_surat = 'manajer';

        $srt_masih_mhw->save();
        return redirect()->back()->with('success', 'Surat berhasil disetujui');
    }

    function manajer(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'tujuan_buat_srt',
                'tujuan_akhir'
            )
            ->where('role_surat', 'manajer');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('tujuan_buat_srt', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_masih_mhw.manajer', compact('data'));
    }

    function setuju_wd($id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $srt_masih_mhw->role_surat = 'manajer_sukses';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.manajer')->with('success', 'Surat berhasil disetujui');
    }

    function setuju_manajer($id)
    {
        $srt_masih_mhw = srt_masih_mhw::where('id', $id)->first();

        $srt_masih_mhw->role_surat = 'mahasiswa';

        $srt_masih_mhw->save();
        return redirect()->route('srt_masih_mhw.manajer')->with('success', 'Surat berhasil disetujui');
    }
}
