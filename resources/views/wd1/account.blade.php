@extends('wd1.layout')
@section('content')
<head>
    <title>My Account {{ auth()->user()->nama }}</title>
</head>
<body>
    <div class="container py-5">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Edit Account</h1>
            <form action='{{ route('wd1.update_account', $user->id) }}' method='post' enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ $user->nama }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nmr_unik" class="form-label">NIP</label>
                    <input type="text" name="nmr_unik" value="{{ $user->nmr_unik }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href='/wd1' class="btn btn-info">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
