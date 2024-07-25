<?php

namespace App\Http\Controllers;

use App\Models\jenjang_pendidikan;
use App\Models\prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Srt_Mhw_AsnController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');

        $query = DB::table('srt_mhw_asn')
            ->where('users_id', $user->id)
            ->select(
                'id',
                'nama_mhw',
                'nim_mhw',
                'nowa_mhw',
                'thn_awl',
                'jenjang_prodi',
                'thn_akh',
                'semester',
                'nama_ortu',
                'nip_ortu',
                'ins_ortu',
                'role_surat'
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

        $data = $query->paginate(10);

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = Prodi::where('id', $user->prd_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_mhw_asn.index', compact('data', 'user', 'jenjang_prodi'));
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
        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = Prodi::where('id', $user->prd_id)->first();

        if ($jenjang && $prodi) {
            $jenjang_prodi = $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd;
        } else {
            return redirect()->back()->withErrors('Data jenjang atau program studi tidak ditemukan.');
        }

        DB::table('srt_mhw_asn')->insert([
            'users_id' => $user->id,
            'prd_id' => $user->prd_id,
            'dpt_id' => $user->dpt_id,
            'jnjg_id' => $user->jnjg_id,
            'nama_mhw' => $user->nama,
            'nim_mhw' => $user->nmr_unik,
            'nowa_mhw' => $user->nowa,
            'thn_awl' => $request->thn_awl,
            'thn_akh' => $request->thn_akh,
            'semester' => $request->semester,
            'nama_ortu' => $request->nama_ortu,
            'nip_ortu' => $request->nip_ortu,
            'ins_ortu' => $request->ins_ortu,
            'jenjang_prodi' => $jenjang_prodi,
        ]);

        return redirect()->route('srt_mhw_asn.index')->with('success', 'Surat berhasil dibuat');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $data = DB::table('srt_mhw_asn')->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('srt_mhw_asn.index')->withErrors('Data tidak ditemukan.');
        }

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = Prodi::where('id', $user->prd_id)->first();
        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_mhw_asn.edit', compact('data', 'user', 'jenjang_prodi'));
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


    function delete()
    {
    }

    public function backup()
    {
        // $data = DB::table('srt_mhw_asn')
        //     ->join('prodi', 'srt_mhw_asn.prd_id', '=', 'prodi.id')
        //     ->join('users', 'srt_mhw_asn.users_id', '=', 'users.id')
        //     ->join('departement', 'srt_mhw_asn.dpt_id', '=', 'departement.id')
        //     ->join('jenjang_pendidikan', 'srt_mhw_asn.jnjg_id', '=', 'jenjang_pendidikan.id')
        //     // ->whereIn('srt_mhw_asn.role_surat', ['tolak', 'mahasiswa', 'alumni', 'admin', 'supervisor_akd', 'supervisor_sd', 'manajer'])
        //     ->select(
        //         'srt_mhw_asn.id',
        //         'srt_mhw_asn.nama_mhw',
        //         'srt_mhw_asn.nim_mhw',
        //         'srt_mhw_asn.nowa_mhw',
        //         'srt_mhw_asn.thn_awl',
        //         'srt_mhw_asn.thn_akh',
        //         'srt_mhw_asn.semester',
        //         'srt_mhw_asn.nama_ortu',
        //         'srt_mhw_asn.nip_ortu',
        //         'srt_mhw_asn.ins_ortu',
        //         'srt_mhw_asn.role_surat',
        //         'users.nama as nama' // Tambahkan ini untuk nama user
        //     )
        $data = DB::table('srt_mhw_asn')
            ->select(
                'id',
                'nama_mhw',
                'nim_mhw',
                'nowa_mhw',
                'thn_awl',
                'jenjang_prodi',
                'thn_akh',
                'semester',
                'nama_ortu',
                'nip_ortu',
                'ins_ortu',
                'role_surat'
            )
            ->paginate(10);

        return view('srt_mhw_asn.index', compact('data'));
    }

    public function backup2()
    {
        $user = Auth::user();

        $jenjang = jenjang_pendidikan::where('id', $user->jnjg_id)->first();
        $prodi = Prodi::where('id', $user->prd_id)->first();

        $jenjang_prodi = ($jenjang && $prodi) ? $jenjang->nama_jnjg . ' - ' . $prodi->nama_prd : 'N/A';

        return view('srt_mhw_asn.create', compact('user', 'jenjang_prodi'));
    }
}
