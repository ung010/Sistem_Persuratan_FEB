<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function user(){
        // $data= buku::query();
        $data = DB::table('users')->where('role', 'mahasiswa')->paginate(20);
        
        return view('admin.mahasiswa')->with('data', $data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $data = User::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('nim', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('nowa', 'LIKE', "%{$query}%")
            ->orWhere('ttl', 'LIKE', "%{$query}%")
            ->orWhere('almt_asl', 'LIKE', "%{$query}%")
            ->orWhere('almt_smg', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('admin.mahasiswa', compact('data'));
    }

    public function search1(Request $request)
    {
        $query = $request->input('query');

        $data = User::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('nim', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('nowa', 'LIKE', "%{$query}%")
            ->orWhere('ttl', 'LIKE', "%{$query}%")
            ->orWhere('almt_asl', 'LIKE', "%{$query}%")
            ->orWhere('almt_smg', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('admin.akses', compact('data'));
    }

    function UsersAkses() {
        $data = DB::table('users')->where('role', '-')->paginate(20);
        
        return view('admin.akses')->with('data', $data);
    }

    public function aksesApprove($id)
    {
        DB::update('UPDATE users SET role = :role WHERE id = :id', ['role' => 'mahasiswa', 'id' => $id]);
        return redirect()->route('admin.akses')->with('success', 'Akun mahasiswa telah di-approve');
    }

    public function bulkApprove(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected_ids'));
        DB::table('users')
            ->whereIn('id', $selectedIds)
            ->update(['role' => 'mahasiswa']);

        return redirect()->route('admin.akses')->with('success', 'Mahasiswa yang dipilih telah di approve');
    }

    public function ApproveAll()
    {
        DB::table('users')->where('role', '-')->update(['role' => 'mahasiswa']);
        
        return redirect()->route('admin.akses')->with('success', 'Semua akun telah di approve.');
    }

    public function nonApprove($id)
    {
        DB::update('UPDATE users SET role = :role WHERE id = :id', ['role' => '-', 'id' => $id]);
        return redirect()->route('admin.mahasiswa')->with('success', 'Akun mahasiswa telah dinonaktifkan');
    }

    public function bulkNonApprove(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected_ids'));
        DB::table('users')
            ->whereIn('id', $selectedIds)
            ->update(['role' => '-']);

        return redirect()->route('admin.mahasiswa')->with('success', 'Mahasiswa yang dipilih telah di non-approve');
    }

    public function nonApproveAll()
    {
        DB::table('users')->where('role', 'mahasiswa')->update(['role' => '-']);
        
        return redirect()->route('admin.mahasiswa')->with('success', 'Semua akun telah di non-approve.');
    }

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
