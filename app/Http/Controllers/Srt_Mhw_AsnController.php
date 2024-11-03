<?php

namespace App\Http\Controllers;

use App\Models\prodi;
use App\Models\srt_mhw_asn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Hashids;

class Srt_Mhw_AsnController extends Controller
{
    private function deletesurat()
    {
        DB::table('srt_mhw_asn')
            ->where('created_at', '<', Carbon::now('Asia/Jakarta')->subMonths(6))
            ->delete();
    }

  public function index(Request $request)
  {
    $user = Auth::user();

    $this->deletesurat();

    $search = $request->input('search');

    $query = DB::table('srt_mhw_asn')
      ->join('prodi', 'srt_mhw_asn.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_mhw_asn.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('users_id', $user->id)
      ->select(
        'srt_mhw_asn.id',
        'users.id as users_id',
        'prodi.id as prd_id',
        'departement.id as departement_id',
        'users.nama',
        'users.nmr_unik',
        'users.nowa',
        'prodi.nama_prd',
        'nama_mhw',
        'thn_awl',
        'thn_akh',
        'semester',
        'nama_ortu',
        'nip_ortu',
        'ins_ortu',
        'role_surat',
      );

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%")
          ->orWhere('nama_ortu', 'like', "%{$search}%")
          ->orWhere('nip_ortu', 'like', "%{$search}%")
          ->orWhere('ins_ortu', 'like', "%{$search}%")
          ->orWhere('thn_awl', 'like', "%{$search}%")
          ->orWhere('thn_akh', 'like', "%{$search}%")
          ->orWhere('semester', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    $prodi = Prodi::where('id', $user->prd_id)->first();
    return view('srt_mhw_asn.index', compact('data', 'user', 'prodi'));
  }

  public function create(Request $request)
  {
    $validated = $request->validate([
      'thn_awl' => 'required',
      'thn_akh' => 'required',
      'nama_ortu' => 'required',
      'nip_ortu' => 'required',
      'ins_ortu' => 'required',
    ], [
      'thn_awl.required' => 'Tahun pertama wajib diisi',
      'thn_akh.required' => 'Tahun kedua wajib diisi',
      'nama_ortu.required' => 'Nama orang tua wajib diisi',
      'nip_ortu.required' => 'NIP orang tua wajib diisi',
      'ins_ortu.required' => 'Instansi orang tua wajib diisi',
    ]);

    $user = Auth::user();

    $existingSurat = DB::table('srt_mhw_asn')
        ->where('users_id', $user->id)
        ->where('role_surat', '!=', 'mahasiswa')
        ->first();

    if ($existingSurat) {
        return redirect()->back()->withErrors(['error' => 'Hanya diperbolehkan satu surat yang diproses hingga surat itu selesai']);
    }

    $id_surat = mt_rand(1000000000000, 9999999999999);

    DB::table('srt_mhw_asn')->insert([
        'id' => $id_surat,
        'users_id' => $user->id,
        'prd_id' => $user->prd_id,
        'nama_mhw' => $user->nama,
        'thn_awl' => $request->thn_awl,
        'thn_akh' => $request->thn_akh,
        'semester' => $request->semester,
        'nama_ortu' => $request->nama_ortu,
        'nip_ortu' => $request->nip_ortu,
        'ins_ortu' => $request->ins_ortu,
        'created_at' => Carbon::now('Asia/Jakarta'),
        'tanggal_surat' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
    ]);

    return redirect()->route('srt_mhw_asn.index')->with('success', 'Surat berhasil dibuat');
  }


  public function edit($id)
  {
      $user = Auth::user();
      $decodedId = Hashids::decode($id);

      $data = DB::table('srt_mhw_asn')->where('id', $decodedId[0])->first();

      if (!$data) {
          return redirect()->route('srt_mhw_asn.index')->withErrors('Data tidak ditemukan.');
      }

      $prodi = Prodi::where('id', $user->prd_id)->first();

      return view('srt_mhw_asn.edit', compact('data', 'user', 'prodi'));
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      'thn_awl' => 'required',
      'thn_akh' => 'required',
      'nama_ortu' => 'required',
      'nip_ortu' => 'required',
      'ins_ortu' => 'required',
    ], [
      'thn_awl.required' => 'Tahun pertama wajib diisi',
      'thn_akh.required' => 'Tahun kedua wajib diisi',
      'nama_ortu.required' => 'Nama orang tua wajib diisi',
      'nip_ortu.required' => 'NIP orang tua wajib diisi',
      'ins_ortu.required' => 'Instansi orang tua wajib diisi',
    ]);

    DB::table('srt_mhw_asn')->where('id', $id)->update([
      'thn_awl' => $request->thn_awl,
      'thn_akh' => $request->thn_akh,
      'semester' => $request->semester,
      'nama_ortu' => $request->nama_ortu,
      'nip_ortu' => $request->nip_ortu,
      'ins_ortu' => $request->ins_ortu,
      'role_surat' => 'admin',
      'catatan_surat' => '-',
    ]);

    return redirect()->route('srt_mhw_asn.index')->with('success', 'Surat berhasil diperbarui');
  }

  function download($id)
  {
    $mpdf = new \Mpdf\Mpdf();

    $srt_mhw_asn = DB::table('srt_mhw_asn')
      ->join('prodi', 'srt_mhw_asn.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_mhw_asn.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('srt_mhw_asn.id', $id)
      ->select(
        'srt_mhw_asn.id',
        'users.id as users_id',
        'prodi.id as prodi_id',
        'users.nama',
        'users.nmr_unik',
        'prodi.nama_prd',
        'srt_mhw_asn.thn_awl',
        'srt_mhw_asn.thn_akh',
        'srt_mhw_asn.nama_ortu',
        'srt_mhw_asn.nip_ortu',
        'srt_mhw_asn.ins_ortu',
        'srt_mhw_asn.tanggal_surat',
        'srt_mhw_asn.no_surat',
        'srt_mhw_asn.semester',
      )
      ->first();

    if ($srt_mhw_asn && $srt_mhw_asn->tanggal_surat) {
      $srt_mhw_asn->tanggal_surat = Carbon::parse($srt_mhw_asn->tanggal_surat)->format('d-m-Y');
    }

    $qrUrl = url('/legal/srt_mhw_asn/' . $srt_mhw_asn->id);
    $qrCodePath = 'storage/qrcodes/qr-' . $srt_mhw_asn->id . '.png';
    $qrCodeFullPath = public_path($qrCodePath);

    if (!File::exists(dirname($qrCodeFullPath))) {
      File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
    }

    QrCode::format('png')->size(100)->generate($qrUrl, $qrCodeFullPath);

    // $mpdf = new Mpdf();
    // $html = View::make('srt_mhw_asn.view', compact('srt_mhw_asn', 'qrCodePath'))->render();
    // $mpdf->WriteHTML($html);

    // Load a view and pass data to it
    $pdf = Pdf::loadView('srt_mhw_asn.view', compact('srt_mhw_asn', 'qrCodePath'));

    // Return the generated PDF as a download

    $namaMahasiswa = $srt_mhw_asn->nama;
    $tanggalSurat = Carbon::now('Asia/Jakarta')->format('Y-m-d');
    $fileName = 'Surat_Mahasiswa_Bagi_ASN_' . str_replace(' ', '_', $namaMahasiswa) . '_' . $tanggalSurat . '.pdf';
    return $pdf->download($fileName);
    // $mpdf->Output($fileName, 'D');
  }

  function admin(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_mhw_asn')
      ->select(
        'id',
        'nama_mhw',
      )
      ->where('role_surat', 'admin')
      ->orderBy('tanggal_surat', 'asc');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_mhw_asn.admin', compact('data'));
  }

  function cek_surat_admin($id)
  {
    $srt_mhw_asn = DB::table('srt_mhw_asn')
      ->join('prodi', 'srt_mhw_asn.prd_id', '=', 'prodi.id')
      ->join('users', 'srt_mhw_asn.users_id', '=', 'users.id')
      ->join('departement', 'prodi.dpt_id', '=', 'departement.id')
      ->where('srt_mhw_asn.id', $id)
      ->select(
        'srt_mhw_asn.id',
        'users.id as users_id',
        'prodi.id as prd_id',
        'departement.id as dpt_id',
        'users.nama',
        'users.nmr_unik',
        'departement.nama_dpt',
        'prodi.nama_prd',
        'srt_mhw_asn.thn_awl',
        'srt_mhw_asn.thn_akh',
        'users.almt_asl',
        'users.nowa',
        'users.email',
        'srt_mhw_asn.nama_ortu',
        'srt_mhw_asn.nip_ortu',
        'srt_mhw_asn.ins_ortu',
        'users.foto',
      )
      ->first();
    return view('srt_mhw_asn.cek_data', compact('srt_mhw_asn'));
  }

  function setuju(Request $request, $id)
  {
    $srt_mhw_asn = srt_mhw_asn::where('id', $id)->first();

    $request->validate([
      'no_surat' => 'required',
    ], [
      'no_surat.required' => 'No surat wajib diisi',
    ]);

    $srt_mhw_asn->no_surat = $request->no_surat;
    $srt_mhw_asn->role_surat = 'supervisor_akd';

    $srt_mhw_asn->save();
    return redirect()->route('srt_mhw_asn.admin')->with('success', 'No surat berhasil ditambahkan');
  }

  function tolak(Request $request, $id)
  {
    $srt_mhw_asn = srt_mhw_asn::where('id', $id)->first();

    $request->validate([
      'catatan_surat' => 'required',
    ], [
      'catatan_surat.required' => 'Alasan penolakan wajib diisi',
    ]);

    $srt_mhw_asn->catatan_surat = $request->catatan_surat;
    $srt_mhw_asn->role_surat = 'tolak';

    $srt_mhw_asn->save();
    return redirect()->route('srt_mhw_asn.admin')->with('success', 'Alasan penolakan telah dikirimkan');
  }

  function supervisor_akd(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_mhw_asn')
      ->select(
        'id',
        'nama_mhw',
      )
      ->where('role_surat', 'supervisor_akd')
      ->orderBy('tanggal_surat', 'asc');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_mhw_asn.supervisor', compact('data'));
  }

  function supervisor_setuju($id)
  {
    $srt_mhw_asn = srt_mhw_asn::where('id', $id)->first();

    $srt_mhw_asn->role_surat = 'manajer';

    $srt_mhw_asn->save();
    return redirect()->back()->with('success', 'Surat berhasil disetujui');
  }

  function manajer(Request $request)
  {
    $search = $request->input('search');

    $query = DB::table('srt_mhw_asn')
      ->select(
        'id',
        'nama_mhw',
      )
      ->where('role_surat', 'manajer')
      ->orderBy('tanggal_surat', 'asc');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('nama_mhw', 'like', "%{$search}%");
      });
    }

    $data = $query->get();

    return view('srt_mhw_asn.manajer', compact('data'));
  }

  function manajer_setuju($id)
  {
    $srt_mhw_asn = srt_mhw_asn::where('id', $id)->first();

    $srt_mhw_asn->role_surat = 'mahasiswa';

    $srt_mhw_asn->save();
    return redirect()->route('srt_mhw_asn.manajer')->with('success', 'Surat berhasil disetujui');
  }

  function delete()
  {
    //
  }
}
