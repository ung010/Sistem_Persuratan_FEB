<?php

namespace App\Http\Controllers;

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
        $data = DB::table('users')->where('role', 'mahasiswa')->paginate(5);
        
        return view('admin.mahasiswa')->with('data', $data);
    }
}
