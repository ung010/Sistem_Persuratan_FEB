@extends('template/admin')
@section('inti_data')

    <head>
        <title>
            Admin - Surat Keterangan mahasiswa bagi anak ASN
        </title>
    </head>

    <body>
        <form method="GET" action="{{ route('srt_magang.admin_search') }}">
            <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit">Cari</button>
        </form>
        <a href="/srt_magang/admin">Reload</a>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-1">Nama Mahasiswa</th>
                        <th class="col-md-1">Cek Data</th>
                        <th class="col-md-1">Status</th>
                        <th class="col-md-1">Unduh</th>
                        <th class="col-md-1">Dikirim</th>
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
                                    <a href='{{ url('/srt_magang/admin/cek_surat/' . $item->id) }}'
                                        class="btn btn-warning btn-sm">Cek Data</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Cek Data</button>
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
                            <td>
                                @if ($item->role_surat == 'manajer_sukses')
                                    <a href='{{ url('/srt_magang/admin/download/' . $item->id) }}'
                                        class="btn btn-primary btn-sm">Unduh</a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unduh</button>
                                @endif
                            </td>
                            <td>
                                @if ($item->role_surat == 'manajer_sukses')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#uploadModal" data-id="{{ $item->id }}"
                                        data-nama="{{ $item->nama_mhw }}">
                                        Unggah Surat
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unggah</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->withQueryString()->links() }}

        <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Unggah Surat Magang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="srt_magang" class="form-label">Unggah Surat</label>
                                <input type="file" name="srt_magang" id="srt_magang" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
            $('#uploadModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');

                var modal = $(this);
                var form = modal.find('form');
                var action = "{{ route('srt_magang.admin_unggah', ['id' => ':id']) }}";

                form.attr('action', action.replace(':id', id));
                modal.find('.modal-title').text('Unggah Surat Magang: ' + nama);
            });
        </script>
    @endsection
