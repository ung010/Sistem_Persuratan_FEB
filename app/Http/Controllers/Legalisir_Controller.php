<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use App\Models\prodi;

class Legalisir_Controller extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->join('prodi', 'legalisir.prd_id', '=', 'prodi.id')
            ->join('users', 'legalisir.users_id', '=', 'users.id')
            ->join('departement', 'legalisir.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'legalisir.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users_id', $user->id)
            ->select(
                'legalisir.id',
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
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%")
                    ->orWhere('users.nmr_unik', 'like', "%{$search}%")
                    ->orWhere('departement.nama_dpt', 'like', "%{$search}%")
                    ->orWhere('users.almt_asl', 'like', "%{$search}%")
                    ->orWhere('almt_kirim', 'like', "%{$search}%")
                    ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('legalisir.index', compact('data', 'user', 'departemen', 'jenjang_prodi'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'file_ijazah' => 'nullable|mimes:pdf|max:500',
            'file_transkrip' => 'nullable|mimes:pdf|max:500',
            'keperluan' => 'required',
            'tgl_lulus' => 'required',
            'jenis_lgl' => 'required',
            'ambil' => 'required',
        ], [
            'file_ijazah.mimes' => 'File ijazah wajib bertipe PDF',
            'file_transkrip.mimes' => 'File transkrip wajib bertipe PDF',
            'file_ijazah.max' => 'Ukuran file transkrip melebihi 500 Kilobytes',
            'file_transkrip.max' => 'Ukuran file ijazah melebihi 500 Kilobytes',
            'keperluan.required' => 'Kolom keperluan wajib diisi',
            'tgl_lulus.required' => 'Kolom tanggal lulus wajib diisi',
            'jenis_lgl.required' => 'Jenis Legalisir wajib diisi',
            'ambil.required' => 'Kolom pengambilan wajib diisi',
        ]);

        $user = Auth::user();

        $nama_ijazah = null;
        if ($request->hasFile('file_ijazah')) {
            $file_ijazah = $request->file('file_ijazah');
            $tanggal_file = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d_His');
            $nama_ijazah = 'Ijazah_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '_' . $tanggal_file . '.' . $file_ijazah->getClientOriginalExtension();
            $file_ijazah->move(public_path('storage/pdf/legalisir/ijazah'), $nama_ijazah);
        }

        $nama_transkrip = null;
        if ($request->hasFile('file_transkrip')) {
            $file_transkrip = $request->file('file_transkrip');
            $tanggal_file = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d_His');
            $nama_transkrip = 'Transkrip_' . str_replace(' ', '_', $user->nama) . '_' . $user->nmr_unik . '_' . $tanggal_file . '.' . $file_transkrip->getClientOriginalExtension();
            $file_transkrip->move(public_path('storage/pdf/legalisir/transkrip'), $nama_transkrip);
        }

        $data = [
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'ambil' => $request->ambil,
            'jenis_lgl' => $request->jenis_lgl,
            'keperluan' => $request->keperluan,
            'tgl_lulus' => $request->tgl_lulus,
            'almt_kirim' => $request->almt_kirim ?: '-',
            'kcmt_kirim' => $request->kcmt_kirim,
            'kdps_kirim' => $request->kdps_kirim,
            'klh_kirim' => $request->klh_kirim,
            'kota_kirim' => $request->kota_kirim,
            'file_ijazah' => $nama_ijazah,
            'file_transkrip' => $nama_transkrip,
            'tanggal_surat' => Carbon::now()->format('Y-m-d'),
        ];

        DB::table('legalisir')->insert($data);

        return redirect()->route('legalisir.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('legalisir')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('legalisir.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = prodi::where('id', $user->prd_id)->first();
        $departemen = departemen::where('id', $user->dpt_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('legalisir.edit', compact('data', 'user', 'jenjang_prodi', 'departemen'));
    }


    public function update(Request $request, $id)
    {
        $data = DB::table('legalisir')->where('id', $id)->first();

        $validated = $request->validate([
            'file_ijazah' => 'nullable|mimes:pdf|max:500',
            'file_transkrip' => 'nullable|mimes:pdf|max:500',
            'keperluan' => 'required',
            'tgl_lulus' => 'required',
            'jenis_lgl' => 'required',
            'ambil' => 'required',
        ], [
            'file_ijazah.mimes' => 'File ijazah wajib bertipe PDF',
            'file_transkrip.mimes' => 'File transkrip wajib bertipe PDF',
            'file_ijazah.max' => 'Ukuran file transkrip melebihi 500 Kilobytes',
            'file_transkrip.max' => 'Ukuran file ijazah melebihi 500 Kilobytes',
            'keperluan.required' => 'Kolom keperluan wajib diisi',
            'tgl_lulus.required' => 'Kolom tanggal lulus wajib diisi',
            'jenis_lgl.required' => 'Jenis Legalisir wajib diisi',
            'ambil.required' => 'Kolom pengambilan wajib diisi',
        ]);

        $updateData = [];

        if ($request->hasFile('file_ijazah')) {
            $file_ijazah = $request->file('file_ijazah');
            $ijazah_extensi = $file_ijazah->extension();
            $tanggal_file = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d_His');
            $nama_ijazah = 'Ijazah_' . str_replace(' ', '_', Auth::user()->nama) . '_' . Auth::user()->nmr_unik . '_' . $tanggal_file . '.' . $ijazah_extensi;
            $file_ijazah->move(public_path('storage/pdf/legalisir/ijazah'), $nama_ijazah);
            $updateData['file_ijazah'] = $nama_ijazah;
        } else {
            $updateData['file_ijazah'] = $data->file_ijazah;
        }

        if ($request->hasFile('file_transkrip')) {
            $file_transkrip = $request->file('file_transkrip');
            $transkrip_extensi = $file_transkrip->extension();
            $tanggal_file = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d_His');
            $nama_transkrip = 'Transkrip_' . str_replace(' ', '_', Auth::user()->nama) . '_' . Auth::user()->nmr_unik . '_' . $tanggal_file . '.' . $transkrip_extensi;
            $file_transkrip->move(public_path('storage/pdf/legalisir/transkrip'), $nama_transkrip);
            $updateData['file_transkrip'] = $nama_transkrip;
        } else {
            $updateData['file_transkrip'] = $data->file_transkrip;
        }

        DB::table('legalisir')->where('id', $id)->update(array_merge($updateData, [
            'ambil' => $request->ambil,
            'jenis_lgl' => $request->jenis_lgl,
            'keperluan' => $request->keperluan,
            'tgl_lulus' => $request->tgl_lulus,
            'almt_kirim' => $request->almt_kirim ?: '-',
            'kcmt_kirim' => $request->kcmt_kirim,
            'kdps_kirim' => $request->kdps_kirim,
            'klh_kirim' => $request->klh_kirim,
            'kota_kirim' => $request->kota_kirim,
            'role_surat' => 'admin',
            'catatan_surat' => '-',
        ]));

        return redirect()->route('legalisir.index')->with('success', 'Surat berhasil diperbarui');
    }
}
