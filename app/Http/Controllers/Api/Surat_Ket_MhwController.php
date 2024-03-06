<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Surat_Ket_Mhw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Surat_Ket_MhwController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Surat_Ket_Mhw::orderby('users_id', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'Data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Surat_Ket_Mhw;
        
        $rules = [
            'tjn_srt' => 'required',
            'thn_awl' => 'required',
            'thn_akh' => 'required',
            'semester' => 'required',
            'role' => 'required',
            'users_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data karena data tidak lengkap',
                'data' => $validator->errors()
            ]);
        }

        $data->no_surat = $request->no_surat;
        $data->tjn_srt = $request->tjn_srt;
        $data->thn_awl = $request->thn_awl;
        $data->thn_akh = $request->thn_akh;
        $data->semester = $request->semester;
        $data->role = $request->role;
        $data->users_id = $request->users_id;

        $post = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data surat'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Surat_Ket_Mhw::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'Data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Surat_Ket_Mhw::find($id);
        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        
        $rules = [
            'tjn_srt' => 'required',
            'thn_awl' => 'required',
            'thn_akh' => 'required',
            'semester' => 'required',
            'role' => 'required',
            'users_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah data karena data tidak lengkap',
                'data' => $validator->errors()
            ]);
        }

        $data->no_surat = $request->no_surat;
        $data->tjn_srt = $request->tjn_srt;
        $data->thn_awl = $request->thn_awl;
        $data->thn_akh = $request->thn_akh;
        $data->semester = $request->semester;
        $data->role = $request->role;
        $data->users_id = $request->users_id;

        $post = $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses mengubah data surat'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Surat_Ket_Mhw::find($id);
        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $post = $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses menghapus data surat'
        ]);
    }
}
