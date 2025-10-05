<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr class="text-center">
                <th>NO</th>
                <th>NAMA</th>
                @for($bulan = 1; $bulan <= 6; $bulan++)
                    <th>Nilai {{ $bulan == 1 ? 'Januari' : ( $bulan == 2 ? 'Februari' : ( $bulan == 3 ? 'Maret' : ( $bulan == 4 ? 'April' : ( $bulan == 5 ? 'Mei' : ( $bulan == 6 ? 'Juni' : '' ) ) ) ) ) }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $s)
            <tr>
                <th> {{ $loop->iteration }} </th>
                <th> {{ $s->nama }} </th>
                @for($bulan = 1; $bulan <= 6; $bulan++)
                    @php
                    $nilaiBulan=$s->nilai->filter(function($nilai) use ($bulan) {
                    return optional($nilai->tugas->jadwal)->tanggal &&
                    \Carbon\Carbon::parse($nilai->tugas->jadwal->tanggal)->month == $bulan;
                    });

                    $rata2 = $nilaiBulan->count() > 0
                    ? number_format((float)$nilaiBulan->avg('nilai'), 2, '.', '.')
                    : '-';
                    @endphp
                    <td>{{ $rata2 }}</td>
                    @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</div>