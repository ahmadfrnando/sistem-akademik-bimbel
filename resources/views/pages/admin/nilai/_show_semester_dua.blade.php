<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr class="text-center">
                <th>NO</th>
                <th>NAMA</th>
                @for($bulan = 7; $bulan <= 12; $bulan++)
                    <th>Nilai {{ $bulan == 7 ? 'Juli' : ( $bulan == 8 ? 'Agustus' : ( $bulan == 9 ? 'September' : ( $bulan == 10 ? 'Oktober' : ( $bulan == 11 ? 'November' : ( $bulan == 12 ? 'Desember' : '' ) ) ) ) ) }}</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $s)
            <tr>
                <th> {{ $loop->iteration }} </th>
                <th> {{ $s->nama }} </th>
                @for($bulan = 7; $bulan <= 12; $bulan++)
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