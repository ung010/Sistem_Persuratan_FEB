@extends('admin.layout')

@section('content')
    <div class="container-fluid p-5">
        <div class="card mx-5">
            <div class="mx-5">
                <div class="card d-inline-block intersection-card">
                    <div class="card-body d-flex gap-2 align-items-center">
                        <img src="{{ asset('asset/icons/big mail.png') }}" alt="big mail" class="heading-image">
                        <p class="heading-card">LEGALISIR IJAZAH</p>
                    </div>
                </div>
                <br>
                <div class="card d-inline-block">
                    <div class="card-header d-flex align-items-center">
                        <a class="btn btn-secondary" href="/legalisir/admin/ditempat/ijazah">Ijazah</a>
                        <a class="btn btn-secondary" href="/legalisir/admin/ditempat/transkrip">Transkrip</a>
                        <a class="btn btn-secondary" href="/legalisir/admin/ditempat/ijz_trs">Ijazah dan Transkrip</a>
                    </div>
                </div>
            </div>
            <div class="card-body my-3">
                <div class="d-flex justify-content-center align-items-center align-content-center">
                    <table class="table table-responsive" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Cek Data</th>
                                <th>Unduh</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_mhw }}</td>
                                    <td>
                                        @if ($item->role_surat == 'admin')
                                            <a href="{{ url('/legalisir/admin/ditempat/ijz_trs/cek_legal/' . $item->id) }}"
                                                class="btn btn-warning btn-sm">Cek Data</a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Cek Data</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->role_surat == 'manajer_sukses')
                                            <a href="{{ url('/legalisir/admin/ditempat/ijz_trs/download/' . $item->id) }}"
                                                class="btn btn-primary btn-sm">Unduh</a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->role_surat == 'admin')
                                            Verif Admin
                                        @elseif ($item->role_surat == 'supervisor_akd')
                                            Verif Supervisor Akademik
                                        @elseif ($item->role_surat == 'manajer')
                                            Verif Manajer
                                        @elseif ($item->role_surat == 'manajer_sukses')
                                            Manajer telah verifikasi
                                        @else
                                            Ditolak
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection
