<td style="min-width: 255px">
    @php
        switch ($item->role_surat) {
            case 'admin':
                $noAction = 2;
                break;

            case 'supervisor_akd':
                $noAction = 3;
                break;

            case 'wd1':
                $noAction = 4;
                break;

            case 'tolak':
                $noAction = 0;
                break;

            case 'mahasiswa':
                $noAction = 6;
                break;

            default:
                $noAction = 1;
                break;
        }
    @endphp
    <div class="d-flex gap-2 justify-content-between align-items-center align-content-center">
        <div class="d-flex flex-column gap-1 justify-content-center align-content-center align-items-center">
            <div
                class="rounded-circle border lacak d-flex justify-content-center align-items-center {{ $noAction > 1 ? 'bg-primary text-white' : ($noAction == 1 ? 'bg-success text-white' : '') }}">
                1
            </div>
            <p class="lacak-text">
                Pengajuan
            </p>
        </div>
        <div class="d-flex flex-column gap-1 justify-content-center align-content-center align-items-center">
            <div
                class="rounded-circle border lacak d-flex justify-content-center align-items-center {{ $noAction > 2 ? 'bg-primary text-white' : ($noAction == 2 ? 'bg-success text-white' : '') }}">
                2
            </div>
            <p class="lacak-text">
                Admin
            </p>
        </div>
        <div class="d-flex flex-column gap-1 justify-content-center align-content-center align-items-center">
            <div
                class="rounded-circle border lacak d-flex justify-content-center align-items-center {{ $noAction > 3 ? 'bg-primary text-white' : ($noAction == 3 ? 'bg-success text-white' : '') }}">
                3
            </div>
            <p class="lacak-text">
                Supervisor
            </p>
        </div>
        <div class="d-flex flex-column gap-1 justify-content-center align-content-center align-items-center">
            <div
                class="rounded-circle border lacak d-flex justify-content-center align-items-center {{ $noAction > 4 ? 'bg-primary text-white' : ($noAction == 4 ? 'bg-success text-white' : '') }}">
                4
            </div>
            <p class="lacak-text">
                Wakil Dekan 1
            </p>
        </div>
    </div>
</td>
