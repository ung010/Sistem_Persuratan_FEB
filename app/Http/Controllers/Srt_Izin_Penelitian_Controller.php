<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use App\Models\srt_izin_penelitian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class Srt_Izin_Penelitian_Controller extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users_id', $user->id)
            ->select(
                'srt_izin_plt.id',
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
                'srt_izin_plt.judul_data',
                'srt_izin_plt.semester',
                'srt_izin_plt.jenis_surat',
                'srt_izin_plt.nama_lmbg',
                'srt_izin_plt.almt_lmbg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_izin_plt.role_surat',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'like', "%{$search}%")
                    ->orWhere('semester', 'like', "%{$search}%")
                    ->orWhere('nama_lmbg', 'like', "%{$search}%")
                    ->orWhere('judul_data', 'like', "%{$search}%")
                    ->orWhere('jenis_surat', 'like', "%{$search}%")
                    ->orWhere('almt_lmbg', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_izin_plt.index', compact('data', 'user', 'departemen', 'jenjang_prodi'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'lampiran' => 'required',
            'semester' => 'required',
            'jenis_surat' => 'required',
            'judul_data' => 'required',
            'nama_lmbg' => 'required',
            'jbt_lmbg' => 'required',
            'kota_lmbg' => 'required',
            'almt_lmbg' => 'required',
        ], [
            'lampiran.required' => 'Lampiran wajib diisi',
            'jenis_surat.required' => 'Permohonan data wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'judul_data.required' => 'Judul/Tema Pengambilan Data Wajib diisi',
            'nama_lmbg.required' => 'Nama perusahaan  / lembaga wajib diisi',
            'jbt_lmbg.required' => 'Jabatan orang perusahaan  / lembaga wajib diisi',
            'kota_lmbg.required' => 'Kota perusahaan / lembaga wajib diisi',
            'almt_lmbg.required' => 'Alamat perusahaan / lembaga wajib diisi',
        ]);

        $user = Auth::user();

        DB::table('srt_izin_plt')->insert([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'lampiran' => $request->lampiran,
            'jenis_surat' => $request->jenis_surat,
            'semester' => $request->semester,
            'judul_data' => $request->judul_data,
            'nama_lmbg' => $request->nama_lmbg,
            'jbt_lmbg' => $request->jbt_lmbg,
            'almt_lmbg' => $request->almt_lmbg,
            'kota_lmbg' => $request->kota_lmbg,
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('srt_izin_plt.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('srt_izin_plt')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('srt_izin_plt.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_izin_plt.edit', compact('data', 'user', 'jenjang_prodi', 'departemen'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'lampiran' => 'required',
            'semester' => 'required',
            'jenis_surat' => 'required',
            'judul_data' => 'required',
            'nama_lmbg' => 'required',
            'jbt_lmbg' => 'required',
            'kota_lmbg' => 'required',
            'almt_lmbg' => 'required',
        ], [
            'lampiran.required' => 'Lampiran wajib diisi',
            'jenis_surat.required' => 'Permohonan data wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'judul_data.required' => 'Judul/Tema Pengambilan Data Wajib diisi',
            'nama_lmbg.required' => 'Nama perusahaan  / lembaga wajib diisi',
            'jbt_lmbg.required' => 'Jabatan orang perusahaan  / lembaga wajib diisi',
            'kota_lmbg.required' => 'Kota perusahaan / lembaga wajib diisi',
            'almt_lmbg.required' => 'Alamat perusahaan / lembaga wajib diisi',
        ]);

        DB::table('srt_izin_plt')->where('id', $id)->update([
            'lampiran' => $request->lampiran,
            'jenis_surat' => $request->jenis_surat,
            'semester' => $request->semester,
            'judul_data' => $request->judul_data,
            'nama_lmbg' => $request->nama_lmbg,
            'jbt_lmbg' => $request->jbt_lmbg,
            'almt_lmbg' => $request->almt_lmbg,
            'kota_lmbg' => $request->kota_lmbg,
            'role_surat' => 'admin',
            'catatan_surat' => '-',
        ]);

        return redirect()->route('srt_izin_plt.index')->with('success', 'Surat berhasil diperbarui');
    }

    function download($id)
    {
        $srt_izin_plt = DB::table('srt_izin_plt')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->where('srt_izin_plt.id', $id)
            ->select('srt_izin_plt.file_pdf', 'users.nama')
            ->first();

        if (!$srt_izin_plt || !$srt_izin_plt->file_pdf) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = public_path('storage/pdf/srt_izin_plt/' . $srt_izin_plt->file_pdf);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $srt_izin_plt->file_pdf);
    }

    function admin(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
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

        return view('srt_izin_plt.admin', compact('data'));
    }

    function admin_unduh($id)
    {
        $srt_izin_plt = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_izin_plt.id', $id)
            ->select(
                'srt_izin_plt.id',
                'srt_izin_plt.no_surat',
                'srt_izin_plt.tanggal_surat',
                'srt_izin_plt.nama_mhw',
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
                'srt_izin_plt.semester',
                'srt_izin_plt.judul_data',
                'srt_izin_plt.nama_lmbg',
                'srt_izin_plt.jbt_lmbg',
                'srt_izin_plt.kota_lmbg',
                'srt_izin_plt.almt_lmbg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_izin_plt.role_surat',
            )
            ->first();

        if (!$srt_izin_plt) {
            return redirect()->back()->with('error', 'Data not found');
        }

        if ($srt_izin_plt->tanggal_surat) {
            $srt_izin_plt->tanggal_surat = Carbon::parse($srt_izin_plt->tanggal_surat)->format('d-m-Y');
        }

        $qrUrl = url('/legal/srt_izin_plt/' . $srt_izin_plt->id);
        $qrCodePath = 'storage/qrcodes/qr-' . $srt_izin_plt->id . '.png';
        $qrCodeFullPath = public_path($qrCodePath);

        if (!File::exists(dirname($qrCodeFullPath))) {
            File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
        }

        QrCode::format('png')->size(100)->generate($qrUrl, $qrCodeFullPath);

        $mpdf = new Mpdf();
        $html = View::make('srt_izin_plt.view', compact('srt_izin_plt', 'qrCodePath'))->render();
        $mpdf->WriteHTML($html);

        $namaMahasiswa = $srt_izin_plt->nama;
        $tanggalSurat = Carbon::now()->format('Y-m-d');
        $fileName = 'Surat_Izin_Penelitian_' . str_replace(' ', '_', $namaMahasiswa) . '_' . $tanggalSurat . '.pdf';
        $mpdf->Output($fileName, 'D');
    }

    public function admin_unggah(Request $request, $id)
    {
        $request->validate([
            'srt_izin_plt' => 'required|mimes:pdf'
        ], [
            'srt_izin_plt.required' => 'Surat wajib diisi',
            'srt_izin_plt.mimes' => 'Surat wajib berbentuk / berekstensi PDF',
        ]);

        $srt_izin_plt = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_izin_plt.id', $id)
            ->select(
                'srt_izin_plt.id',
                'users.nama',
                'srt_izin_plt.tanggal_surat'
            )
            ->first();

        if (!$srt_izin_plt) {
            return redirect()->back()->withErrors('Data surat tidak ditemukan.');
        }

        $tanggal_surat = Carbon::parse($srt_izin_plt->tanggal_surat)->format('d-m-Y');
        $nama_mahasiswa = Str::slug($srt_izin_plt->nama);

        $file = $request->file('srt_izin_plt');
        $surat_extensi = $file->extension();
        $nama_surat = "Surat_Izin_Penelitian_{$tanggal_surat}_{$nama_mahasiswa}." . $surat_extensi;
        $file->move(public_path('storage/pdf/srt_izin_plt'), $nama_surat);

        srt_izin_penelitian::where('id', $id)->update([
            'file_pdf' => $nama_surat,
            'role_surat' => 'mahasiswa',
        ]);

        return redirect()->back()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');
    }

    function admin_cek($id)
    {
        $srt_izin_plt = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_izin_plt.id', $id)
            ->select(
                'srt_izin_plt.id',
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
                'srt_izin_plt.lampiran',
                'srt_izin_plt.nama_lmbg',
                'srt_izin_plt.jbt_lmbg',
                'srt_izin_plt.kota_lmbg',
                'srt_izin_plt.almt_lmbg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_izin_plt.role_surat',
            )
            ->first();
        return view('srt_izin_plt.cek_data', compact('srt_izin_plt'));
    }

    function admin_setuju(Request $request, $id)
    {
        $srt_izin_plt = srt_izin_penelitian::where('id', $id)->first();

        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'No surat wajib diisi',
        ]);

        $srt_izin_plt->no_surat = $request->no_surat;
        $srt_izin_plt->role_surat = 'supervisor_akd';

        $srt_izin_plt->save();
        return redirect()->route('srt_izin_plt.admin')->with('success', 'No surat berhasil ditambahkan');
    }

    function admin_tolak(Request $request, $id)
    {
        $srt_izin_plt = srt_izin_penelitian::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $srt_izin_plt->catatan_surat = $request->catatan_surat;
        $srt_izin_plt->role_surat = 'tolak';

        $srt_izin_plt->save();
        return redirect()->route('srt_izin_plt.admin')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    function supervisor(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('role_surat', 'supervisor_akd')
            ->select(
                'srt_izin_plt.id',
                'srt_izin_plt.nama_mhw',
                'srt_izin_plt.tanggal_surat',
                'srt_izin_plt.nama_lmbg',
                'users.nmr_unik',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('nama_lmbg', 'like', "%{$search}%")
                ->orWhere('nmr_unik', 'like', "%{$search}%")
                ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_izin_plt.supervisor', compact('data'));
    }

    function setuju_sv($id)
    {
        $srt_izin_plt = srt_izin_penelitian::where('id', $id)->first();

        $srt_izin_plt->role_surat = 'manajer';

        $srt_izin_plt->save();
        return redirect()->back()->with('success', 'Surat berhasil disetujui');
    }

    function manajer(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->join('prodi', 'srt_izin_plt.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_izin_plt.users_id', '=', 'users.id')
            ->join('departement', 'srt_izin_plt.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_izin_plt.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('role_surat', 'manajer')
            ->select(
                'srt_izin_plt.id',
                'srt_izin_plt.nama_mhw',
                'srt_izin_plt.tanggal_surat',
                'srt_izin_plt.nama_lmbg',
                'users.nmr_unik',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('nama_lmbg', 'like', "%{$search}%")
                ->orWhere('nmr_unik', 'like', "%{$search}%")
                ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_izin_plt.manajer', compact('data'));
    }

    function setuju_manajer($id)
    {
        $srt_izin_plt = srt_izin_penelitian::where('id', $id)->first();

        $srt_izin_plt->role_surat = 'manajer_sukses';

        $srt_izin_plt->save();
        return redirect()->route('srt_izin_plt.manajer')->with('success', 'Surat berhasil disetujui');
    }
}
