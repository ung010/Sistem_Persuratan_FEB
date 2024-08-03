<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Riwayat_Surat_Controller extends Controller
{
    function admin_srt_mhw_asn(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_mhw_asn')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_mhw_asn', compact('data'));
    }

    function admin_srt_masih_mhw(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_masih_mhw', compact('data'));
    }

    function admin_legalisir(Request $request) {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.legalisir', compact('data'));
    }

    function admin_srt_bbs_pnjm(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_bbs_pnjm')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_bbs_pnjm', compact('data'));
    }

    function admin_srt_izin_plt(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_izin_plt', compact('data'));
    }

    function admin_srt_pmhn_kmbali_biaya(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_pmhn_kmbali_biaya', compact('data'));
    }

    function admin_srt_magang(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_magang')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_admin.srt_magang', compact('data'));
    }

    function manajer_srt_mhw_asn(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_mhw_asn')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.srt_mhw_asn', compact('data'));
    }

    function manajer_srt_masih_mhw(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.srt_masih_mhw', compact('data'));
    }

    function manajer_legalisir(Request $request) {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.legalisir', compact('data'));
    }

    function manajer_srt_izin_plt(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.srt_izin_plt', compact('data'));
    }

    function manajer_srt_pmhn_kmbali_biaya(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.srt_pmhn_kmbali_biaya', compact('data'));
    }

    function manajer_srt_magang(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_magang')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_manajer.srt_magang', compact('data'));
    }

    function sv_akd_srt_mhw_asn(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_mhw_asn')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_akd.srt_mhw_asn', compact('data'));
    }

    function sv_akd_srt_masih_mhw(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_masih_mhw')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_akd.srt_masih_mhw', compact('data'));
    }

    function sv_akd_legalisir(Request $request) {
        $search = $request->input('search');

        $query = DB::table('legalisir')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_akd.legalisir', compact('data'));
    }

    function sv_sd_srt_bbs_pnjm(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_bbs_pnjm')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_sd.srt_bbs_pnjm', compact('data'));
    }

    function sv_akd_srt_izin_plt(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_izin_plt')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_akd.srt_izin_plt', compact('data'));
    }

    function sv_sd_srt_pmhn_kmbali_biaya(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_pmhn_kmbali_biaya')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_sd.srt_pmhn_kmbali_biaya', compact('data'));
    }

    function sv_akd_srt_magang(Request $request) {
        $search = $request->input('search');

        $query = DB::table('srt_magang')
            ->select(
                'id',
                'nama_mhw',
                'role_surat',
            )
            ->Where('role_surat', 'mahasiswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mhw', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        return view('riwayat_sv_akd.srt_magang', compact('data'));
    }
}
