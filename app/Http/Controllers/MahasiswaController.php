<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\prodi;
use App\Models\departemen;
use App\Models\jenjang_pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Survey;

class MahasiswaController extends Controller
{

  public function index()
  {
    $user = Auth::user();
    $existingSurvey = Survey::where('users_id', $user->id)->first();

    $data = [
      'user' => $user,
      'existingSurvey' => $existingSurvey,
    ];

    return view('mahasiswa.index', $data);
  }

  function edit()
  {
    $jenjang_pendidikan = jenjang_pendidikan::get();
    $departemen = departemen::get();
    $prodi = prodi::get();
    $user = Auth::user();

    $data = [
      'jenjang_pendidikan' => $jenjang_pendidikan,
      'departemen' => $departemen,
      'prodi' => $prodi,
      'user' => $user,
    ];
    return view('mahasiswa.account', $data);
  }

  function update(Request $request)
  {
    $userId = Auth::id();

    $request->validate([
      'nama' => 'required',
      'nmr_unik' => 'required|unique:users,nmr_unik,' . $userId,
      'email' => 'required|email|unique:users,email,' . $userId,
      'kota' => 'required',
      'tanggal_lahir' => 'required',
      'nowa' => 'required',
      'nama_ibu' => 'required',
      'almt_asl' => 'required',
      'dpt_id' => 'required',
      'prd_id' => 'required',
      'jnjg_id' => 'required',
      'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
    ], [
      'nama.required' => 'Nama wajib diisi',
      'nmr_unik.required' => 'NIM wajib diisi',
      'nmr_unik.unique' => 'NIM sudah digunakan, silakan masukkan NIM yang lain',
      'email.required' => 'Email wajib diisi',
      'email.email' => 'Email harus valid',
      'email.unique' => 'Email sudah digunakan, silakan masukkan Email yang lain',
      'kota.required' => 'Tempat lahir wajib diisi',
      'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
      'nowa.required' => 'No handphone wajib diisi',
      'almt_asl.required' => 'Alamat asal rumah wajib diisi',
      'dpt_id.required' => 'Departemen wajib diisi',
      'prd_id.required' => 'Prodi wajib diisi',
      'jnjg_id.required' => 'Jenjang pendidikan wajib diisi',
      'foto.image' => 'File harus berupa gambar',
      'foto.mimes' => 'File harus berupa gambar dengan format jpeg, png, atau jpg',
      'foto.max' => 'Ukuran file gambar maksimal adalah 2048 kilobyte'
    ]);

    DB::table('users')->where('id', $userId)->update([
      'nama' => $request->nama,
      'nmr_unik' => $request->nmr_unik,
      'email' => $request->email,
      'kota' => $request->kota,
      'tanggal_lahir' => $request->tanggal_lahir,
      'nowa' => $request->nowa,
      'almt_asl' => $request->almt_asl,
      'jnjg_id' => $request->jnjg_id,
      'dpt_id' => $request->dpt_id,
      'prd_id' => $request->prd_id,
      'password' => $request->filled('password') ? Hash::make($request->password) : DB::raw('password'),
      'foto' => $request->hasFile('foto') ? $this->handleFileUpload($request->file('foto')) : DB::raw('foto')
    ]);
    return redirect()->back()->with('success', 'Berhasil mengupdate data diri');
  }

  private function handleFileUpload($file)
  {
    $fileExtension = $file->extension();
    $fileName = date('ymdhis') . '.' . $fileExtension;
    $file->move(public_path('storage/foto/mahasiswa'), $fileName);
    return $fileName;
  }
}
