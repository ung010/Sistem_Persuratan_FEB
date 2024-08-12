@extends('template/mahasiswa')
@section('inti_data')
    <head>
        <title>
            Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_mhw_asn.search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_mhw_asn">Reload</a>
        <a class="btn btn-primary btn-sm">Tambah surat</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Semester Saat ini-TA</th>
                        <th class="col-md-1">Nama Orang Tua</th>
                        <th class="col-md-1">NIP / Pensiun</th>
                        <th class="col-md-1">Instansi Orang tua / Pangkat</th>
                        <th class="col-md-1">Lacak (Role)</th>
                        <th class="col-md-1">Status (Role)</th>
                        <th class="col-md-1">Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->nama_mhw }}</td>
                            <td>
                                Smt {{ $item->semester }} -
                                {{$item->thn_awl}}/{{$item->thn_akh}}
                            </td>
                            <td>{{ $item->nama_ortu }}</td>
                            <td>{{ $item->nip_ortu }}</td>
                            <td>{{ $item->ins_ortu }}</td>
                            <td>
                                {{ $item->role_surat }}
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <button class="btn btn-success btn-sm">Berhasil</button>
                                @elseif ($item->role_surat == 'tolak')
                                <a href="{{ url('/srt_mhw_asn/edit', ['id' => $item->id]) }}" class="btn btn-danger btn-sm">Ditolak</a>
                                @else
                                    <button class="btn btn-primary btn-sm" disabled>Menunggu</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'mahasiswa')
                                    <a href='{{ url('/srt_mhw_asn/download/'.$item->id) }}' class="btn btn-primary btn-sm">Unduh</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $data->withQueryString()->links() }}

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h2>Buat Surat Baru</h2>
            <div class="container py-5 login">
                <div class="w-50 center border rounded px-3 py-3 mx-auto land">
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('srt_mhw_asn.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="nama_mhw">Nama Mahasiswa:</label>
                            <input type="text" id="nama_mhw" name="nama_mhw" value="{{ $user->nama }}" disabled>
                        </div>
                        <div>
                            <label for="nim_mhw">NIM Mahasiswa:</label>
                            <input type="text" id="nim_mhw" name="nim_mhw" value="{{ $user->nmr_unik }}" disabled>
                        </div>
                        <label for="jenjang_prodi">Jenjang Prodi:</label>
                        <input type="text" name="jenjang_prodi" id="jenjang_prodi" value="{{ $jenjang_prodi }}"
                            disabled>
                        <br>                        
                        <div>
                            <label for="nowa_mhw">Nomor WA Mahasiswa:</label>
                            <input type="text" id="nowa_mhw" name="nowa_mhw" value="{{ $user->nowa }}" disabled>
                        </div>

                        <label for="thn_awl">Tahun Awal:</label>
                        <input type="number" name="thn_awl" id="thn_awl" required>
                        <br>

                        <label for="thn_akh">Tahun Akhir:</label>
                        <input type="number" name="thn_akh" id="thn_akh" required>
                        <br>

                        <div>
                            <label for="semester">Semester:</label>
                            <select name="semester" id="semester" required>
                                @for ($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <label for="nama_ortu">Nama Orang Tua:</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" required>
                        <br>

                        <label for="nip_ortu">NIP Orang Tua:</label>
                        <input type="number" name="nip_ortu" id="nip_ortu" required>
                        <br>

                        <label for="ins_ortu">Institusi Orang Tua:</label>
                        <input type="text" name="ins_ortu" id="ins_ortu" required>
                        <br>

                        <button type="submit">Simpan</button>
                    </form>
                </div>
    </body>
    </div>
    </div>

@endsection
