<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SuratKetMhw extends Controller
{
    function index() {
        return view ('suratketmhw.index');
    }

    function create() {        
        $data = DB::table('users')
            ->where('nama', auth()->user()->nama) // Mengambil data berdasarkan nama pengguna yang sedang masuk
            ->paginate(1);
        return view ('suratketmhw.create')->with('data', $data);
    }

    function store(Request $request) {
        Session::flash('tanggal_masuk', $request->tanggal_masuk);
        Session::flash('judul_buku', $request->judul_buku);
        Session::flash('penulis', $request->penulis);

        $request->validate([
            'tanggal_masuk' => 'required',
            'judul_buku' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
        ], [
            'tanggal_masuk.required' => 'Tanggal Masuk wajib diisi',
            'judul_buku.required' => 'Judul Buku wajib diisi',
            'penulis.required' => 'Penulis wajib diisi',
            'penerbit.required' => 'Penerbit wajib diisi',
        ]);

        $data = [
            'nama' => $request->nama,
            'nmr_unik' => $request->nmr_unik,
            'email' => $request->email,
            'ttl' => $request->ttl,
            'nowa' => $request->nowa,
            'almt_asl' => $request->almt_asl,
            'almt_smg' => $request->almt_smg,
            'dpt_id' => $request->dpt_id,
            'prd_id' => $request->prd_id,
        ];
        User::create($data);

        return redirect()->route('suratketmhw.create')->with('success', 'Berhasil menambahkan surat');
    }
}
