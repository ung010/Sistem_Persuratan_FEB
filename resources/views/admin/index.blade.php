@extends('template/admin')
@section('inti_data')
    <title>Halo xx</title>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Halo {{ auth()->user()->nama }}</h1>

        <div class="mt-3">
            <h4>Surat Masih Kuliah: {{ $srt_masih_mhw }}</h4>
            <h4>Surat Keterangan Mahasiswa bagi ASN: {{ $srt_mhw_asn }}</h4>
            <h4>Surat Bebas Pinjam: {{ $srt_bbs_pnjm }}</h4>
            <h4>Surat Izin Penelitian: {{ $srt_izin_plt }}</h4>
            <h4>Surat Surat Magang: {{ $srt_magang }}</h4>
            <h4>Surat Permohonan Pengembalian Biaya: {{ $srt_pmhn_kmbali_biaya }}</h4>
            <h4>Legalisir: {{ $legalisir }}</h4>

            <h4>Total Surat Selesai: {{ $total_surat }}</h4>
        </div>
    </div>
    
    {{-- <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d H:i:s') }}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();
            
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
            
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Display the result in the element with id="countdown"
            document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
            
            // If the count down is finished, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script> --}}
@endsection