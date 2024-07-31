<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use App\Models\srt_pmhn_kmbali_biaya;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class srt_pmhn_kmbali_biaya_controller extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users_id', $user->id)
            ->select(
                'srt_pmhn_kmbali_biaya.id',
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
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'jenjang_pendidikan.nama_jnjg',
                'srt_pmhn_kmbali_biaya.skl',
                'srt_pmhn_kmbali_biaya.bukti_bayar',
                'srt_pmhn_kmbali_biaya.buku_tabung',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_pmhn_kmbali_biaya.role_surat',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'like', "%{$search}%")
                    ->orWhere('departement.nama_dpt', 'like', "%{$search}%")
                    ->orWhere('users.almt_asl', 'like', "%{$search}%")
                    ->orWhere('users.nowa', 'like', "%{$search}%")
                    ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        $kota = $user->kota;
        $tanggal_lahir = $user->tanggal_lahir;
        $kota_tanggal_lahir = ($kota && $tanggal_lahir) ? $kota . ', ' . \Carbon\Carbon::parse($tanggal_lahir)->format('d F Y') : 'N/A';

        return view('srt_pmhn_kmbali_biaya.index', compact('data', 'user', 'departemen', 'jenjang_prodi', 'kota_tanggal_lahir'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'skl' => 'required|mimes:pdf|max:500',
            'bukti_bayar' => 'required|mimes:pdf|max:500',
            'buku_tabung' => 'required|mimes:pdf|max:500',
        ], [
            'skl.required' => 'SKL wajib diisi',
            'bukti_bayar.required' => 'Bukti Bayar wajib diisi',
            'buku_tabung.required' => 'Buku Tabungan wajib diisi',
            'skl.mimes' => 'SKL wajib bertipe PDF',
            'bukti_bayar.mimes' => 'Bukti bayar wajib bertipe PDF',
            'buku_tabung.mimes' => 'Buku tabungan wajib bertipe PDF',
            'skl.max' => 'Ukuran file SKL melebihi 500 Kilobytes',
            'bukti_bayar.max' => 'Ukuran file Bukti Bayar melebihi 500 Kilobytes',
            'buku_tabung.max' => 'Ukuran file Buku Tabungan melebihi 500 Kilobytes',
        ]);

        $user = Auth::user();
        
        $skl = $request->file('skl');
        $nama_skl = 'SKL_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.' . $skl->getClientOriginalExtension();
        $skl->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_skl);
    
        $bukti_bayar = $request->file('bukti_bayar');
        $nama_bukti = 'Bukti_Bayar_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.' . $bukti_bayar->getClientOriginalExtension();
        $bukti_bayar->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_bukti);
    
        $buku_tabung = $request->file('buku_tabung');
        $nama_buku = 'Buku_Tabungan_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '.' . $buku_tabung->getClientOriginalExtension();
        $buku_tabung->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_buku);
        

        DB::table('srt_pmhn_kmbali_biaya')->insert([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'skl' => $nama_skl,
            'bukti_bayar' => $nama_bukti,
            'buku_tabung' => $nama_buku,
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('srt_pmhn_kmbali_biaya.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('srt_pmhn_kmbali_biaya')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('srt_pmhn_kmbali_biaya.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';
        
        $kota = $user->kota;
        $tanggal_lahir = $user->tanggal_lahir;
        $kota_tanggal_lahir = ($kota && $tanggal_lahir) ? $kota . ', ' . \Carbon\Carbon::parse($tanggal_lahir)->format('d F Y') : 'N/A';

        return view('srt_pmhn_kmbali_biaya.edit', compact('data', 'user', 'jenjang_prodi', 'departemen', 'kota_tanggal_lahir'));
    }


    public function update(Request $request, $id)
{
    $data = DB::table('srt_pmhn_kmbali_biaya')->where('id', $id)->first();

    $validated = $request->validate([
        'skl' => 'nullable|mimes:pdf|max:500',
        'bukti_bayar' => 'nullable|mimes:pdf|max:500',
        'buku_tabung' => 'nullable|mimes:pdf|max:500',
    ], [
        'skl.mimes' => 'SKL harus berformat PDF',
        'bukti_bayar.mimes' => 'Bukti Bayar harus berformat PDF',
        'buku_tabung.mimes' => 'Buku Tabungan harus berformat PDF',
        'skl.max' => 'Ukuran file SKL melebihi 500 Kilobytes',
        'bukti_bayar.max' => 'Ukuran file Bukti Bayar melebihi 500 Kilobytes',
        'buku_tabung.max' => 'Ukuran file Buku Tabungan melebihi 500 Kilobytes',
    ]);

    $updateData = [];

    if ($request->hasFile('skl')) {
        $skl = $request->file('skl');
        $skl_extensi = $skl->extension();
        $nama_skl = 'SKL_' . str_replace(' ', '_', Auth::user()->nama) . '_' . Auth::user()->nmr_unik . '.' . $skl_extensi;
        $skl->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_skl);
        $updateData['skl'] = $nama_skl;
    } else {
        $updateData['skl'] = $data->skl;
    }

    if ($request->hasFile('bukti_bayar')) {
        $bukti_bayar = $request->file('bukti_bayar');
        $bayar_extensi = $bukti_bayar->extension();
        $nama_bukti = 'Bukti_Bayar_' . str_replace(' ', '_', Auth::user()->nama) . '_' . Auth::user()->nmr_unik . '.' . $bayar_extensi;
        $bukti_bayar->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_bukti);
        $updateData['bukti_bayar'] = $nama_bukti;
    } else {
        $updateData['bukti_bayar'] = $data->bukti_bayar;
    }

    if ($request->hasFile('buku_tabung')) {
        $buku_tabung = $request->file('buku_tabung');
        $buku_extensi = $buku_tabung->extension();
        $nama_buku = 'Buku_Tabungan_' . str_replace(' ', '_', Auth::user()->nama) . '_' . Auth::user()->nmr_unik . '.' . $buku_extensi;
        $buku_tabung->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya/bukti_files'), $nama_buku);
        $updateData['buku_tabung'] = $nama_buku;
    } else {
        $updateData['buku_tabung'] = $data->buku_tabung;
    }

    DB::table('srt_pmhn_kmbali_biaya')->where('id', $id)->update(array_merge($updateData, [
        'role_surat' => 'admin',
        'catatan_surat' => '-',
    ]));

    return redirect()->route('srt_pmhn_kmbali_biaya.index')->with('success', 'Surat berhasil diperbarui');
}


    function download($id)
    {
        $srt_pmhn_kmbali_biaya = DB::table('srt_pmhn_kmbali_biaya')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->where('srt_pmhn_kmbali_biaya.id', $id)
            ->select('srt_pmhn_kmbali_biaya.file_pdf', 'users.nama')
            ->first();

        if (!$srt_pmhn_kmbali_biaya || !$srt_pmhn_kmbali_biaya->file_pdf) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = public_path('storage/pdf/srt_pmhn_kmbali_biaya/' . $srt_pmhn_kmbali_biaya->file_pdf);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath, $srt_pmhn_kmbali_biaya->file_pdf);
    }

    function admin(Request $request)
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

    function admin_unduh($id)
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

    public function admin_unggah(Request $request, $id)
    {
        $request->validate([
            'srt_pmhn_kmbali_biaya' => 'required|mimes:pdf'
        ], [
            'srt_pmhn_kmbali_biaya.required' => 'Surat wajib diisi',
            'srt_pmhn_kmbali_biaya.mimes' => 'Surat wajib berbentuk / berekstensi PDF',
        ]);

        $srt_pmhn_kmbali_biaya = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_pmhn_kmbali_biaya.id', $id)
            ->select(
                'srt_pmhn_kmbali_biaya.id',
                'users.nama',
                'srt_pmhn_kmbali_biaya.tanggal_surat'
            )
            ->first();

        if (!$srt_pmhn_kmbali_biaya) {
            return redirect()->back()->withErrors('Data surat tidak ditemukan.');
        }

        $tanggal_surat = Carbon::parse($srt_pmhn_kmbali_biaya->tanggal_surat)->format('d-m-Y');
        $nama_mahasiswa = Str::slug($srt_pmhn_kmbali_biaya->nama);

        $file = $request->file('srt_pmhn_kmbali_biaya');
        $surat_extensi = $file->extension();
        $nama_surat = "Surat_Permohonan_Pengembalian_Biaya_{$tanggal_surat}_{$nama_mahasiswa}." . $surat_extensi;
        $file->move(public_path('storage/pdf/srt_pmhn_kmbali_biaya'), $nama_surat);

        srt_pmhn_kmbali_biaya::where('id', $id)->update([
            'file_pdf' => $nama_surat,
            'role_surat' => 'mahasiswa',
        ]);

        return redirect()->back()->with('success', 'Berhasil menggunggah pdf ke mahasiswa');
    }

    function admin_cek($id)
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

    function admin_setuju(Request $request, $id)
    {
        $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('id', $id)->first();

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

    function admin_tolak(Request $request, $id)
    {
        $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('id', $id)->first();

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

    function supervisor(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('role_surat', 'supervisor_akd')
            ->select(
                'srt_pmhn_kmbali_biaya.id',
                'srt_pmhn_kmbali_biaya.nama_mhw',
                'users.nmr_unik',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('nmr_unik', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_pmhn_kmbali_biaya.supervisor', compact('data'));
    }

    function setuju_sv($id)
    {
        $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('id', $id)->first();

        $srt_pmhn_kmbali_biaya->role_surat = 'manajer';

        $srt_pmhn_kmbali_biaya->save();
        return redirect()->back()->with('success', 'Surat berhasil disetujui');
    }

    function manajer(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->join('prodi', 'srt_pmhn_kmbali_biaya.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_pmhn_kmbali_biaya.users_id', '=', 'users.id')
            ->join('departement', 'srt_pmhn_kmbali_biaya.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_pmhn_kmbali_biaya.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('role_surat', 'manajer')
            ->select(
                'srt_pmhn_kmbali_biaya.id',
                'srt_pmhn_kmbali_biaya.nama_mhw',
                'users.nmr_unik',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('nmr_unik', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_pmhn_kmbali_biaya.manajer', compact('data'));
    }

    function setuju_manajer($id)
    {
        $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('id', $id)->first();

        $srt_pmhn_kmbali_biaya->role_surat = 'manajer_sukses';

        $srt_pmhn_kmbali_biaya->save();
        return redirect()->route('srt_pmhn_kmbali_biaya.manajer')->with('success', 'Surat berhasil disetujui');
    }
}
