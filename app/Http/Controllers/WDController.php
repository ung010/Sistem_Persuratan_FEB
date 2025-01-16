<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\srt_izin_penelitian;
use App\Models\Srt_Magang;
use App\Models\srt_masih_mhw;
use App\Models\srt_pmhn_kmbali_biaya;

class WDController extends Controller
{
    public function index_wd1()
  {
    $srt_masih_mhw = srt_masih_mhw::where('role_surat', 'wd1')->count();
    $srt_izin_plt = srt_izin_penelitian::where('role_surat', 'wd1')->count();
    $srt_magang = Srt_Magang::where('role_surat', 'wd1')->count();
    $total_surat =
      srt_masih_mhw::where('role_surat', 'mahasiswa')->count() +
      srt_izin_penelitian::where('role_surat', 'mahasiswa')->count() +
      Srt_Magang::where('role_surat', 'mahasiswa')->count();

    return view('wd1.index', compact(
      'srt_masih_mhw',
      'srt_izin_plt',
      'srt_magang',
      'total_surat'
    ));
  }

  public function index_wd2()
  {
    $srt_pmhn_kmbali_biaya = srt_pmhn_kmbali_biaya::where('role_surat', 'manajer')->count();
    $total_surat =
      srt_pmhn_kmbali_biaya::where('role_surat', 'mahasiswa')->count();

    return view('wd2.index', compact(
      'srt_pmhn_kmbali_biaya',
      'total_surat'
    ));
  }
}
