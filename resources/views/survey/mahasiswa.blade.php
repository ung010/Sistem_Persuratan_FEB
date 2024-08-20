@extends('template/mahasiswa')

@section('inti_data')
    <h1>Halaman Survey</h1>
    <p>Terima kasih telah berpartisipasi dalam survei ini. Silakan isi survei berikut dengan penilaian Anda dan berikan feedback.</p>


    <form action="{{ route('survey.mahasiswa_create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="rating">Penilaian Anda:</label>
            <div>
                <label>
                    <input type="radio" name="rating" value="sangat_puas" required {{ old('rating') == 'sangat_puas' ? 'checked' : '' }}>
                    Sangat Puas
                </label>
                <label>
                    <input type="radio" name="rating" value="puas" {{ old('rating') == 'puas' ? 'checked' : '' }}>
                    Puas
                </label>
                <label>
                    <input type="radio" name="rating" value="netral" {{ old('rating') == 'netral' ? 'checked' : '' }}>
                    Netral
                </label>
                <label>
                    <input type="radio" name="rating" value="kurang_puas" {{ old('rating') == 'kurang_puas' ? 'checked' : '' }}>
                    Kurang Puas
                </label>
                <label>
                    <input type="radio" name="rating" value="tidak_puas" {{ old('rating') == 'tidak_puas' ? 'checked' : '' }}>
                    Tidak Puas
                </label>
            </div>
        </div>

        {{-- Feedback --}}
        <div class="form-group">
            <label for="feedback">Kritik dan Saran:</label>
            <textarea name="feedback" id="feedback" rows="4" class="form-control">{{ old('feedback') }}</textarea>
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
@endsection
