<?php

namespace App\Http\Controllers;

use App\Models\srt_masih_mhw;
use App\Models\srt_mhw_asn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManajerController extends Controller
{
    public function index()
    {
        $srt_mhw_asn = srt_mhw_asn::where('role_surat', 'manajer')->count();
        $srt_masih_mhw = srt_masih_mhw::where('role_surat', 'manajer')->count();

        return view('manajer.index', compact('srt_masih_mhw', 'srt_mhw_asn'));
    }

    function edit_account($id)
    {
        $user = User::findOrFail($id);
        return view('manajer.account', compact('user'));
    }

    function update_account(Request $request, $id)
    {
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
        return redirect()->back()->with('success', 'Data diri telah diperbarui');

    }

    public function manage_spv()
    {
        $data = DB::table('users')
            ->whereIn('users.role', ['supervisor_akd', 'supervisor_sd'])
            ->select(
                'id',
                'nama',
                'email',
                'nmr_unik'
            )
            ->paginate(10);

        return view('manajer.manage_supervisor', compact('data'));
    }

    public function edit_spv(Request $request, $id)
    {
        // dd($id);
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
        return redirect()->back()->with('success', 'Data supervisor telah diperbarui');
    }
}