<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function user()
    {
        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->whereIn('users.role', ['mahasiswa', 'alumni'])
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'prodi.nama_prd',
                'departement.nama_dpt'
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
            ->where('users.nama', 'LIKE', "%{$query}%")
            ->orWhere('users.nmr_unik', 'LIKE', "%{$query}%")
            ->orWhere('users.email', 'LIKE', "%{$query}%")
            ->orWhere('prodi.nama_prd', 'LIKE', "%{$query}%")
            ->orWhere('departement.nama_dpt', 'LIKE', "%{$query}%")
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'prodi.nama_prd',
                'departement.nama_dpt'
            )
            ->paginate(10);

        return view('admin.user', compact('data'));
    }

    public function verif_user()
    {
        $data = DB::table('users')
            ->join('prodi', 'users.prd_id', '=', 'prodi.id')
            ->join('departement', 'users.dpt_id', '=', 'departement.id')
            ->whereIn('users.role', ['non_mahasiswa', 'non_alumni'])
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'prodi.nama_prd',
                'departement.nama_dpt'
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
            ->where('users.nama', 'LIKE', "%{$query}%")
            ->orWhere('users.nmr_unik', 'LIKE', "%{$query}%")
            ->orWhere('users.email', 'LIKE', "%{$query}%")
            ->orWhere('prodi.nama_prd', 'LIKE', "%{$query}%")
            ->orWhere('departement.nama_dpt', 'LIKE', "%{$query}%")
            ->select(
                'users.id',
                'users.nama',
                'users.nmr_unik',
                'prodi.nama_prd',
                'departement.nama_dpt'
            )
            ->paginate(10);

        return view('admin.verifikasi', compact('data'));
    }

    function delete_user($id) {
        $data =  User::where('id', $id)->first();
        File::delete(public_path('storage/foto/mahasiswa'). '/' . $data->foto);
        User::where('id', $id)->delete();
        return redirect ('/admin/user')->with('success', 'Berhasil menghapus akun');
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
