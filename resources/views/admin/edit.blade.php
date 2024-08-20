@extends('template/admin')
@section('inti_data')
<head>
    <title>My Account {{ auth()->user()->nama }}</title>
</head>
<body>
    <div class="container py-5">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Edit Account</h1>
            <form action='{{ route('admin.update', $user->id) }}' method='post' enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href='/admin/user' class="btn btn-info">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body> 
@endsection