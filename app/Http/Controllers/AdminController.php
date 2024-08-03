<?php

namespace App\Http\Controllers;

use App\Models\legalisir;
use App\Models\srt_bbs_pnjm;
use App\Models\srt_izin_penelitian;
use App\Models\Srt_Magang;
use App\Models\srt_masih_mhw;
use App\Models\srt_mhw_asn;
use App\Models\srt_pmhn_kmbali_biaya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $srt_mhw_asn = srt_mhw_asn::where('role_surat', 'admin')->count();
        $srt_masih_mhw = srt_masih_mhw::where('role_surat', 'admin')->count();
        $srt_bbs_pnjm = srt_bbs_pnjm::where('role_surat', 'admin')->count();
        $srt_izin_plt = srt_izin_penelitian::where('role_surat', 'admin')->count();
        $srt_magang = Srt_Magang::where('role_surat', 'admin')->count();
        $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('role_surat', 'admin')->count();
        $legalisir = legalisir::where('role_surat', 'admin')->count();
        $total_surat =
            srt_mhw_asn::where('role_surat', 'mahasiswa')->count() +
            srt_masih_mhw::where('role_surat', 'mahasiswa')->count() +
            srt_bbs_pnjm::where('role_surat', 'mahasiswa')->count() +
            srt_izin_penelitian::where('role_surat', 'mahasiswa')->count() +
            Srt_Magang::where('role_surat', 'mahasiswa')->count() +
            srt_pmhn_kmbali_biaya::where('role_surat', 'mahasiswa')->count() +
            legalisir::where('role_surat', 'mahasiswa')->count();

        return view('admin.index', compact(
            'srt_mhw_asn',
            'srt_masih_mhw',
            'srt_bbs_pnjm',
            'srt_izin_plt',
            'srt_magang',
            'srt_pmhn_kmbali_biaya',
            'legalisir',
            'total_surat'
        ));
    }

    public function user()
    {
        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'users.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users.role', 'mahasiswa')
            ->whereIn('users.status', ['mahasiswa', 'alumni'])
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'departement.nama_dpt',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            )
            ->paginate(10);

        return view('admin.user')->with('data', $data);
    }

    public function search_user(Request $request)
    {
        $query = $request->input('query');

        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'users.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users.role', 'mahasiswa')
            ->whereIn('users.status', ['mahasiswa', 'alumni'])
            ->where(function ($q) use ($query) {
                $q->where('users.nama', 'LIKE', "%{$query}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$query}%")
                    ->orWhere('users.email', 'LIKE', "%{$query}%")
                    ->orWhere('prodi.nama_prd', 'LIKE', "%{$query}%")
                    ->orWhere('departement.nama_dpt', 'LIKE', "%{$query}%")
                    ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'LIKE', "%{$query}%");
            })
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'prodi.nama_prd',
                'departement.nama_dpt',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi')
            )
            ->paginate(10);

        return view('admin.user', compact('data'));
    }

    public function verif_user()
    {
        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'users.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users.role', 'non_mahasiswa')
            ->whereIn('users.status', ['mahasiswa', 'alumni'])
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'departement.nama_dpt',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            )
            ->paginate(10);

        return view('admin.verifikasi')->with('data', $data);
    }

    public function search_verif(Request $request)
    {
        $query = $request->input('query');

        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'users.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users.role', 'non_mahasiswa')
            ->whereIn('users.status', ['mahasiswa', 'alumni'])
            ->where(function ($q) use ($query) {
                $q->where('users.nama', 'LIKE', "%{$query}%")
                    ->orWhere('users.nmr_unik', 'LIKE', "%{$query}%")
                    ->orWhere('users.email', 'LIKE', "%{$query}%")
                    ->orWhere('departement.nama_dpt', 'LIKE', "%{$query}%")
                    ->orWhere(DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd)'), 'LIKE', "%{$query}%");
            })
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'departement.nama_dpt',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            )
            ->paginate(10);

        return view('admin.verifikasi', compact('data'));
    }

    function delete_user($id)
    {
        $data =  User::where('id', $id)->first();
        File::delete(public_path('storage/foto/mahasiswa') . '/' . $data->foto);
        User::where('id', $id)->delete();
        return redirect('/admin/user')->with('success', 'Berhasil menghapus akun');
    }

    function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.user')->with('success', 'Berhasil mengupdate data user');
    }

    function cekdata_mhw($id)
    {
        $user = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->join('jenjang_pendidikan', 'users.jnjg_id', '=', 'jenjang_pendidikan.id')
            ->where('users.id', $id)
            ->select(
                'users.id',
                'prodi.id as prodi_id',
                'departement.id as departement_id',
                'jenjang_pendidikan.id as jenjang_pendidikan_id',
                'users.nama',
                'users.nmr_unik',
                DB::raw('CONCAT(users.kota, ", ", DATE_FORMAT(users.tanggal_lahir, "%d-%m-%Y")) as ttl'),
                'users.nowa',
                'users.nama_ibu',
                'users.foto',
                'users.role',
                'users.email',
                'users.almt_asl',
                'departement.nama_dpt',
                'jenjang_pendidikan.nama_jnjg',
                DB::raw('CONCAT(jenjang_pendidikan.nama_jnjg, " - ", prodi.nama_prd) as jenjang_prodi'),
            )
            ->first();
        return view('admin.cekdata', compact('user'));
    }

    public function catatan(Request $request, $id)
    {
        $users = User::findOrFail($id);

        $request->validate([
            'catatan_user' => 'required',
        ], [
            'catatan_user.required' => 'Catatan kepada user wajib diisi',
        ]);

        $users->catatan_user = $request->catatan_user;

        $users->save();
        return redirect()->back()->with('success', 'Catatan berhasil ditambahkan');
    }

    function verifikasi($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if ($user->role == 'non_mahasiswa') {
            DB::table('users')->where('id', $id)->update(['role' => 'mahasiswa']);
        }

        return redirect()->route('admin.verifikasi')->with('success', 'Akun telah diverifikasi');
    }

    function sampah()
    {
    }

    function restore()
    {
    }

    // public function aksesApprove($id)
    // {
    //     DB::update('UPDATE users SET role = :role WHERE id = :id', ['role' => 'mahasiswa', 'id' => $id]);
    //     return redirect()->route('admin.akses')->with('success', 'Akun mahasiswa telah di-approve');
    // }

    // public function bulkApprove(Request $request)
    // {
    //     $selectedIds = explode(',', $request->input('selected_ids'));
    //     DB::table('users')
    //         ->whereIn('id', $selectedIds)
    //         ->update(['role' => 'mahasiswa']);

    //     return redirect()->route('admin.akses')->with('success', 'Mahasiswa yang dipilih telah di approve');
    // }

    // public function ApproveAll()
    // {
    //     DB::table('users')->where('role', '-')->update(['role' => 'mahasiswa']);

    //     return redirect()->route('admin.akses')->with('success', 'Semua akun telah di approve.');
    // }

    // public function nonApprove($id)
    // {
    //     DB::update('UPDATE users SET role = :role WHERE id = :id', ['role' => '-', 'id' => $id]);
    //     return redirect()->route('admin.mahasiswa')->with('success', 'Akun mahasiswa telah dinonaktifkan');
    // }

    // public function bulkNonApprove(Request $request)
    // {
    //     $selectedIds = explode(',', $request->input('selected_ids'));
    //     DB::table('users')
    //         ->whereIn('id', $selectedIds)
    //         ->update(['role' => '-']);

    //     return redirect()->route('admin.mahasiswa')->with('success', 'Mahasiswa yang dipilih telah di non-approve');
    // }

    // public function nonApproveAll()
    // {
    //     DB::table('users')->where('role', 'mahasiswa')->update(['role' => '-']);

    //     return redirect()->route('admin.mahasiswa')->with('success', 'Semua akun telah di non-approve.');
    // }

    // public function user()
    // {
    //     $data = DB::table('users')
    //         ->where('role', 'mahasiswa')
    //         ->select(
    //             'id',
    //             'nama',
    //             'nmr_unik',
    //             'kota',
    //             DB::raw('DATE_FORMAT(tanggal_lahir, "%d-%m-%Y") as tanggal_lahir'),
    //             DB::raw('CONCAT(kota, ", ", DATE_FORMAT(tanggal_lahir, "%d-%m-%Y")) as ttl'),
    //             'nowa',
    //             'email',
    //             'almt_asl',
    //             'almt_smg',
    //             'foto',
    //         )
    //         ->paginate(20);

    //     return view('admin.user')->with('data', $data);
    // }

    // function softDelete($id) {
    //     DB::update('UPDATE kp SET deleted_at = 1 WHERE id = :id', ['id' => $id]);
    //     return redirect()->route('kp.update_admin')->with('success', 'Berhasil hapus data KP secara sementara');
    // }

    // function restore($id){
    //     DB::update('UPDATE kp SET deleted_at = 0 WHERE id = :id', ['id' => $id]);
    //     return redirect()->route('kp.update_admin')->with('success', 'Data KP telah dikembalikan!');
    // }

    // function pinjam($id) {
    //     DB::update('UPDATE buku SET status_pinjam = 1 WHERE kode_gabungan_final = :kode_gabungan_final', ['kode_gabungan_final' => $id]);
    //     return redirect()->route('buku.update_admin')->with('success', 'Buku Dipinjam');
    // }
}
