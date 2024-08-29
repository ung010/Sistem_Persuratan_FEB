<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\prodi;
use App\Models\Srt_Magang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Hashids;

class Srt_Magang_Controller extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();

    $search = $request->input('search');

    $query = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('users_id', $user->id)
      ->select(
        'srt_magang.id',
        'users.id as users_id',
        'prodi.id as prd_id',
        'departement.id as dpt_id',
        'users.nama',
        'users.nmr_unik',
        'users.nowa',
        'users.email',
        'departement.nama_dpt',
        'prodi.nama_prd',
        'srt_magang.semester',
        'srt_magang.ipk',
        'srt_magang.sksk',
        'srt_magang.nama_lmbg',
        'srt_magang.jbt_lmbg',
        'srt_magang.kota_lmbg',
        'srt_magang.almt_lmbg',
        'srt_magang.almt_smg',
        'srt_magang.role_surat',
      );

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%")
          ->orWhere('users.nmr_unik', 'like', "%{$search}%")
          ->orWhere('users.nowa', 'like', "%{$search}%")
          ->orWhere('almt_smg', 'like', "%{$search}%")
          ->orWhere('semester', 'like', "%{$search}%")
          ->orWhere('nama_lmbg', 'like', "%{$search}%")
          ->orWhere('almt_lmbg', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    $prodi = prodi::where('id', $user->prd_id)->first();
    $departemen = departemen::where('id', $prodi->dpt_id)->first();

    return view('srt_magang.index', compact('data', 'user', 'departemen', 'prodi'));
  }

  public function create(Request $request)
  {
    $validated = $request->validate([
      'almt_smg' => 'required',
      'semester' => 'required',
      'ipk' => 'required',
      'sksk' => 'required',
      'nama_lmbg' => 'required',
      'jbt_lmbg' => 'required',
      'kota_lmbg' => 'required',
      'almt_lmbg' => 'required',
    ], [
      'ipk.required' => 'IPK wajib diisi',
      'sksk.required' => 'SKSK wajib diisi',
      'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
      'semester.required' => 'Semester wajib diisi',
      'nama_lmbg.required' => 'Nama perusahaan  / lembaga wajib diisi',
      'jbt_lmbg.required' => 'Jabatan orang perusahaan  / lembaga wajib diisi',
      'kota_lmbg.required' => 'Kota perusahaan / lembaga wajib diisi',
      'almt_lmbg.required' => 'Alamat perusahaan / lembaga wajib diisi',
    ]);

    $user = Auth::user();
    $id_surat = mt_rand(1000000000000, 9999999999999);

    DB::table('srt_magang')->insert([
      'id' => $id_surat,
      'users_id' => $user->id,
      'prd_id' => $user->prd_id,
      'nama_mhw' => $user->nama,
      'ipk' => $request->ipk,
      'sksk' => $request->sksk,
      'almt_smg' => $request->almt_smg,
      'semester' => $request->semester,
      'nama_lmbg' => $request->nama_lmbg,
      'jbt_lmbg' => $request->jbt_lmbg,
      'almt_lmbg' => $request->almt_lmbg,
      'kota_lmbg' => $request->kota_lmbg,
      'tanggal_surat' => Carbon::now()->format('Y-m-d'),
    ]);

    return redirect()->route('srt_magang.index')->with('success', 'Surat berhasil dibuat');
  }

  public function edit($id)
  {
    $user = Auth::user();

    $decodedId = Hashids::decode($id);

    $data = DB::table('srt_magang')->where('id', $decodedId[0])->first();

    if (!$data) {
      return redirect()->route('srt_magang.index')->withErrors('Data tidak ditemukan.');
    }

    $prodi = prodi::where('id', $user->prd_id)->first();
    $departemen = departemen::where('id', $prodi->dpt_id)->first();

    return view('srt_magang.edit', compact('data', 'user', 'prodi', 'departemen'));
  }


  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'almt_smg' => 'required',
      'semester' => 'required',
      'ipk' => 'required',
      'sksk' => 'required',
      'nama_lmbg' => 'required',
      'jbt_lmbg' => 'required',
      'kota_lmbg' => 'required',
      'almt_lmbg' => 'required',
    ], [
      'ipk.required' => 'IPK wajib diisi',
      'sksk.required' => 'SKSK wajib diisi',
      'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
      'semester.required' => 'Semester wajib diisi',
      'nama_lmbg.required' => 'Nama perusahaan  / lembaga wajib diisi',
      'jbt_lmbg.required' => 'Jabatan orang perusahaan  / lembaga wajib diisi',
      'kota_lmbg.required' => 'Kota perusahaan / lembaga wajib diisi',
      'almt_lmbg.required' => 'Alamat perusahaan / lembaga wajib diisi',
    ]);

    DB::table('srt_magang')->where('id', $id)->update([
      'ipk' => $request->ipk,
      'sksk' => $request->sksk,
      'almt_smg' => $request->almt_smg,
      'semester' => $request->semester,
      'nama_lmbg' => $request->nama_lmbg,
      'jbt_lmbg' => $request->jbt_lmbg,
      'almt_lmbg' => $request->almt_lmbg,
      'kota_lmbg' => $request->kota_lmbg,
      'role_surat' => 'admin',
      'catatan_surat' => '-',
    ]);

    return redirect()->route('srt_magang.index')->with('success', 'Surat berhasil diperbarui');
  }

  function download($id)
  {
    $srt_magang = DB::table('srt_magang')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->where('srt_magang.id', $id)
      ->select('srt_magang.file_pdf', 'users.nama')
      ->first();

    if (!$srt_magang || !$srt_magang->file_pdf) {
      return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    $filePath = public_path('storage/pdf/srt_magang/' . $srt_magang->file_pdf);

    if (!file_exists($filePath)) {
      return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    return response()->download($filePath, $srt_magang->file_pdf);
  }

  function admin(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_magang')
      ->select(
        'id',
        'nama_mhw',
        'role_surat',
      )
      ->whereIn('role_surat', ['admin', 'supervisor_akd', 'manajer', 'manajer_sukses'])
      ->orderByRaw("FIELD(role_surat, 'manajer_sukses', 'admin', 'supervisor_akd', 'manajer')")
      ->orderBy('tanggal_surat', 'asc');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%")
          ->orWhere('role_surat', 'LIKE', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_magang.admin', compact('data'));
  }

  function admin_unduh($id)
  {
    $srt_magang = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('srt_magang.id', $id)
      ->select(
        'srt_magang.id',
        'srt_magang.no_surat',
        'srt_magang.tanggal_surat',
        'srt_magang.nama_mhw',
        'users.id as users_id',
        'prodi.id as prodi_id',
        'departement.id as departement_id',
        'users.nama',
        'users.nmr_unik',
        'users.nowa',
        'users.email',
        'departement.nama_dpt',
        'prodi.nama_prd',
        'srt_magang.semester',
        'srt_magang.ipk',
        'srt_magang.sksk',
        'srt_magang.nama_lmbg',
        'srt_magang.jbt_lmbg',
        'srt_magang.kota_lmbg',
        'srt_magang.almt_lmbg',
        'srt_magang.almt_smg',
        'srt_magang.role_surat',
      )
      ->first();

    if (!$srt_magang) {
      return redirect()->back()->with('error', 'Data not found');
    }

    if ($srt_magang->tanggal_surat) {
      $srt_magang->tanggal_surat = Carbon::parse($srt_magang->tanggal_surat)->format('d-m-Y');
    }

    $qrUrl = url('/legal/srt_magang/' . $srt_magang->id);
    $qrCodePath = 'storage/qrcodes/qr-' . $srt_magang->id . '.png';
    $qrCodeFullPath = public_path($qrCodePath);

    if (!File::exists(dirname($qrCodeFullPath))) {
      File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
    }

    QrCode::format('png')->size(100)->generate($qrUrl, $qrCodeFullPath);

    // $mpdf = new Mpdf();
    // $html = View::make('srt_magang.view', compact('srt_magang', 'qrCodePath'))->render();
    // $mpdf->WriteHTML($html);
    $pdf = Pdf::loadView('srt_magang.view', compact('srt_magang', 'qrCodePath'));

    $namaMahasiswa = $srt_magang->nama;
    $tanggalSurat = Carbon::now()->format('Y-m-d');
    $fileName = 'Surat_Magang_' . str_replace(' ', '_', $namaMahasiswa) . '_' . $tanggalSurat . '.pdf';
    // $mpdf->Output($fileName, 'D');
    return $pdf->download($fileName);
  }

  public function admin_unggah(Request $request, $id)
  {
    $request->validate([
      'srt_magang' => 'required|mimes:pdf'
    ], [
      'srt_magang.required' => 'Surat wajib diisi',
      'srt_magang.mimes' => 'Surat wajib berbentuk / berekstensi PDF',
    ]);

    $srt_magang = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('srt_magang.id', $id)
      ->select(
        'srt_magang.id',
        'users.nama',
        'srt_magang.tanggal_surat'
      )
      ->first();

    if (!$srt_magang) {
      return redirect()->back()->withErrors('Data surat tidak ditemukan.');
    }

    $tanggal_surat = Carbon::parse($srt_magang->tanggal_surat)->format('d-m-Y');
    $nama_mahasiswa = Str::slug($srt_magang->nama);

    $file = $request->file('srt_magang');
    $surat_extensi = $file->extension();
    $nama_surat = "Surat_Magang_{$tanggal_surat}_{$nama_mahasiswa}." . $surat_extensi;
    $file->move(public_path('storage/pdf/srt_magang'), $nama_surat);

    Srt_Magang::where('id', $id)->update([
      'file_pdf' => $nama_surat,
      'role_surat' => 'mahasiswa',
    ]);

    return redirect()->back()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');
  }

  function admin_cek($id)
  {
    $srt_magang = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('srt_magang.id', $id)
      ->select(
        'srt_magang.id',
        'users.id as users_id',
        'prodi.id as prodi_id',
        'departement.id as departement_id',
        'users.nama',
        'users.nmr_unik',
        'users.nowa',
        'users.foto',
        'users.email',
        'departement.nama_dpt',
        'prodi.nama_prd',
        'srt_magang.semester',
        'srt_magang.ipk',
        'srt_magang.sksk',
        'srt_magang.nama_lmbg',
        'srt_magang.jbt_lmbg',
        'srt_magang.kota_lmbg',
        'srt_magang.almt_lmbg',
        'srt_magang.almt_smg',
        'srt_magang.role_surat',
      )
      ->first();
    return view('srt_magang.cek_data', compact('srt_magang'));
  }

  function admin_setuju(Request $request, $id)
  {
    $srt_magang = Srt_Magang::where('id', $id)->first();

    $request->validate([
      'no_surat' => 'required',
    ], [
      'no_surat.required' => 'No surat wajib diisi',
    ]);

    $srt_magang->no_surat = $request->no_surat;
    $srt_magang->role_surat = 'supervisor_akd';

    $srt_magang->save();
    return redirect()->route('srt_magang.admin')->with('success', 'No surat berhasil ditambahkan');
  }

  function admin_tolak(Request $request, $id)
  {
    $srt_magang = Srt_Magang::where('id', $id)->first();

    $request->validate([
      'catatan_surat' => 'required',
    ], [
      'catatan_surat.required' => 'Alasan penolakan wajib diisi',
    ]);

    $srt_magang->catatan_surat = $request->catatan_surat;
    $srt_magang->role_surat = 'tolak';

    $srt_magang->save();
    return redirect()->route('srt_magang.admin')->with('success', 'Alasan penolakan telah dikirimkan');
  }

  function supervisor(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('role_surat', 'supervisor_akd')
      ->orderBy('tanggal_surat', 'asc')
      ->select(
        'srt_magang.id',
        'srt_magang.nama_mhw',
        'srt_magang.tanggal_surat',
        'srt_magang.nama_lmbg',
        'users.nmr_unik',
        'prodi.nama_prd'
      );

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%")
          ->orWhere('nama_lmbg', 'like', "%{$search}%")
          ->orWhere('users.nmr_unik', 'like', "%{$search}%")
          ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_magang.supervisor', compact('data'));
  }

  function setuju_sv($id)
  {
    $srt_magang = Srt_Magang::where('id', $id)->first();

    $srt_magang->role_surat = 'manajer';

    $srt_magang->save();
    return redirect()->back()->with('success', 'Surat berhasil disetujui');
  }

  function manajer(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_magang')
      ->join('prodi', 'srt_magang.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_magang.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('role_surat', 'manajer')
      ->orderBy('tanggal_surat', 'asc')
      ->select(
        'srt_magang.id',
        'srt_magang.nama_mhw',
        'srt_magang.tanggal_surat',
        'srt_magang.nama_lmbg',
        'users.nmr_unik',
        'prodi.nama_prd',
      );

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%")
          ->orWhere('nama_lmbg', 'like', "%{$search}%")
          ->orWhere('users.nmr_unik', 'like', "%{$search}%")
          ->orWhere('prodi.nama_prd', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_magang.manajer', compact('data'));
  }

  function setuju_manajer($id)
  {
    $srt_magang = Srt_Magang::where('id', $id)->first();

    $srt_magang->role_surat = 'manajer_sukses';

    $srt_magang->save();
    return redirect()->route('srt_magang.manajer')->with('success', 'Surat berhasil disetujui');
  }
}
