<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use App\Models\srt_bbs_pnjm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Srt_Bbs_Pnjam_Controller extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('srt_bbs_pnjm')
            ->join('prodi', 'srt_bbs_pnjm.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_bbs_pnjm.users_id', '=', 'users.id')
            ->join('departement', 'srt_bbs_pnjm.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_bbs_pnjm.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users_id', $user->id)
            ->select(
                'srt_bbs_pnjm.id',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'srt_bbs_pnjm.dosen_wali',
                'srt_bbs_pnjm.almt_smg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_bbs_pnjm.role_surat',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'like', "%{$search}%")
                    ->orWhere('users.nowa', 'like', "%{$search}%")
                    ->orWhere('almt_smg', 'like', "%{$search}%")
                    ->orWhere('departement.nama_dpt', 'like', "%{$search}%")
                    ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_bbs_pnjm.index', compact('data', 'user', 'departemen', 'jenjang_prodi'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'almt_smg' => 'required',
            'dosen_wali' => 'required',
        ], [
            'dosen_wali.required' => 'Dosen Wali wajib diisi',
            'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
        ]);

        $user = Auth::user();

        DB::table('srt_bbs_pnjm')->insert([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'dosen_wali' => $request->dosen_wali,
            'almt_smg' => $request->almt_smg,
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('srt_bbs_pnjm.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('srt_bbs_pnjm')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('srt_bbs_pnjm.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_bbs_pnjm.edit', compact('data', 'user', 'jenjang_prodi', 'departemen'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'almt_smg' => 'required',
            'dosen_wali' => 'required',
        ], [
            'dosen_wali.required' => 'Dosen Wali wajib diisi',
            'almt_smg.required' => 'Alamat kos / tempat tinggal semarang wajib diisi',
        ]);

        DB::table('srt_bbs_pnjm')->where('id', $id)->update([
            'dosen_wali' => $request->dosen_wali,
            'almt_smg' => $request->almt_smg,
            'role_surat' => 'admin',
            'catatan_surat' => '-',
        ]);

        return redirect()->route('srt_bbs_pnjm.index')->with('success', 'Surat berhasil diperbarui');
    }

    function download($id)
    {
        $srt_bbs_pnjm = DB::table('srt_bbs_pnjm')
            ->join('prodi', 'srt_bbs_pnjm.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_bbs_pnjm.users_id', '=', 'users.id')
            ->join('departement', 'srt_bbs_pnjm.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_bbs_pnjm.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_bbs_pnjm.id', $id)
            ->select(
                'srt_bbs_pnjm.id',
                'srt_bbs_pnjm.no_surat',
                'srt_bbs_pnjm.tanggal_surat',
                'srt_bbs_pnjm.nama_mhw',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'srt_bbs_pnjm.dosen_wali',
                'srt_bbs_pnjm.almt_smg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_bbs_pnjm.role_surat',
            )
            ->first();

        if (!$srt_bbs_pnjm) {
            return redirect()->back()->with('error', 'Data not found');
        }

        if ($srt_bbs_pnjm->tanggal_surat) {
            $srt_bbs_pnjm->tanggal_surat = Carbon::parse($srt_bbs_pnjm->tanggal_surat)->format('d-m-Y');
        }

        $qrUrl = url('/legal/srt_bbs_pnjm/' . $srt_bbs_pnjm->id);
        $qrCodePath = 'storage/qrcodes/qr-' . $srt_bbs_pnjm->id . '.png';
        $qrCodeFullPath = public_path($qrCodePath);

        if (!File::exists(dirname($qrCodeFullPath))) {
            File::makeDirectory(dirname($qrCodeFullPath), 0755, true);
        }

        QrCode::format('png')->size(100)->generate($qrUrl, $qrCodeFullPath);

        $mpdf = new Mpdf();
        $html = View::make('srt_bbs_pnjm.view', compact('srt_bbs_pnjm', 'qrCodePath'))->render();
        $mpdf->WriteHTML($html);

        $namaMahasiswa = $srt_bbs_pnjm->nama;
        $tanggalSurat = Carbon::now()->format('Y-m-d');
        $fileName = 'Surat_Bebas_Pinjam_' . str_replace(' ', '_', $namaMahasiswa) . '_' . $tanggalSurat . '.pdf';
        $mpdf->Output($fileName, 'D');
    }

    function admin(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_bbs_pnjm')
            ->select(
                'id',
                'nama_mhw',
            )
            ->where('role_surat', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_bbs_pnjm.admin', compact('data'));
    }

    function admin_cek($id)
    {
        $srt_bbs_pnjm = DB::table('srt_bbs_pnjm')
            ->join('prodi', 'srt_bbs_pnjm.prd_id', '=', 'prodi.id')
            ->join('users', 'srt_bbs_pnjm.users_id', '=', 'users.id')
            ->join('departement', 'srt_bbs_pnjm.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'srt_bbs_pnjm.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('srt_bbs_pnjm.id', $id)
            ->select(
                'srt_bbs_pnjm.id',
                'srt_bbs_pnjm.no_surat',
                'srt_bbs_pnjm.tanggal_surat',
                'srt_bbs_pnjm.nama_mhw',
                'users.id as users_id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                'users.nowa',
                'users.foto',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                'srt_bbs_pnjm.dosen_wali',
                'srt_bbs_pnjm.almt_smg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
                'srt_bbs_pnjm.role_surat',
            )
            ->first();
        return view('srt_bbs_pnjm.cek_data', compact('srt_bbs_pnjm'));
    }

    function admin_setuju(Request $request, $id)
    {
        $srt_bbs_pnjm = srt_bbs_pnjm::where('id', $id)->first();

        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'No surat wajib diisi',
        ]);

        $srt_bbs_pnjm->no_surat = $request->no_surat;
        $srt_bbs_pnjm->role_surat = 'supervisor_sd';

        $srt_bbs_pnjm->save();
        return redirect()->route('srt_bbs_pnjm.admin')->with('success', 'No surat berhasil ditambahkan');
    }

    function admin_tolak(Request $request, $id)
    {
        $srt_bbs_pnjm = srt_bbs_pnjm::where('id', $id)->first();

        $request->validate([
            'catatan_surat' => 'required',
        ], [
            'catatan_surat.required' => 'Alasan penolakan wajib diisi',
        ]);

        $srt_bbs_pnjm->catatan_surat = $request->catatan_surat;
        $srt_bbs_pnjm->role_surat = 'tolak';

        $srt_bbs_pnjm->save();
        return redirect()->route('srt_bbs_pnjm.admin')->with('success', 'Alasan penolakan telah dikirimkan');
    }

    function supervisor(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('srt_bbs_pnjm')
            ->join('users', 'srt_bbs_pnjm.users_id', '=', 'users.id')
            ->where('role_surat', 'supervisor_sd')
            ->select(
                'srt_bbs_pnjm.id',
                'srt_bbs_pnjm.nama_mhw',
                'users.nmr_unik',
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                ->orWhere('users.nmr_unik', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('srt_bbs_pnjm.supervisor', compact('data'));
    }

    function setuju_sv($id)
    {
        $srt_bbs_pnjm = srt_bbs_pnjm::where('id', $id)->first();

        $srt_bbs_pnjm->role_surat = 'mahasiswa';

        $srt_bbs_pnjm->save();
        return redirect()->back()->with('success', 'Surat berhasil disetujui');
    }
}
