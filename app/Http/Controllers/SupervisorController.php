<?php

namespace App\Http\Controllers;

use App\Models\srt_masih_mhw;
use App\Models\srt_mhw_asn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SupervisorController extends Controller
{
    public function index_akd()
    {
        $srt_mhw_asn = srt_mhw_asn::where('role_surat', 'supervisor_akd')->count();
        $srt_masih_mhw = srt_masih_mhw::where('role_surat', 'supervisor_akd')->count();

        return view('supervisor_akd.index', compact('srt_masih_mhw', 'srt_mhw_asn'));
    }

    public function manage_admin_akd()
    {
        $data = DB::table('users')
            ->where('role', 'admin')
            ->select(
                'id',
                'nama',
                'email',
                'nmr_unik'
            )
            ->paginate(10);

        return view('supervisor_akd.manage_admin', compact('data'));
    }

    function delete_admin_akd($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data admin berhasil dihapuskan');
    }

    public function create_akd(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $data = [
            'nama' => $request->nama,
            'nmr_unik' => $request->nmr_unik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role to admin
        ];
        User::create($data);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit_akd(Request $request, $id)
    {
        // dd($id); // Tambahkan ini untuk debugging
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users,nmr_unik,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
        ]);

        $user->nama = $request->nama;
        $user->nmr_unik = $request->nmr_unik;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Data admin telah diperbarui');
    }


    public function index_sd()
    {
        return view('supervisor_sd.index');
    }

    public function manage_admin_sd()
    {
        $data = DB::table('users')
            ->where('role', 'admin')
            ->select(
                'id',
                'nama',
                'email',
                'nmr_unik'
            )
            ->paginate(10);

        return view('supervisor_sd.manage_admin', compact('data'));

        // return view('supervisor_sd.manage_admin')->with('data', $data);
    }

    function delete_admin_sd($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data admin berhasil dihapuskan');
    }

    public function create_sd(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $data = [
            'nama' => $request->nama,
            'nmr_unik' => $request->nmr_unik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role to admin
        ];
        User::create($data);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit_sd(Request $request, $id)
    {
        // dd($id); // Tambahkan ini untuk debugging
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nmr_unik' => 'required|unique:users,nmr_unik,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nmr_unik.required' => 'NIM wajib diisi',
            'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
        ]);

        $user->nama = $request->nama;
        $user->nmr_unik = $request->nmr_unik;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Data admin telah diperbarui');
    }
}
