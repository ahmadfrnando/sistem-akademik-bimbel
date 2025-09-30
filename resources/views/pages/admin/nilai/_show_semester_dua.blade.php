<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA</th>
                @for($bulan = 7; $bulan <= 12; $bulan++)
                    <th colspan="5">Nilai {{ $bulan == 7 ? 'Juli' : ( $bulan == 8 ? 'Agustus' : ( $bulan == 9 ? 'September' : ( $bulan == 10 ? 'Oktober' : ( $bulan == 11 ? 'November' : ( $bulan == 12 ? 'Desember' : '' ) ) ) ) ) }}</th>
                    @endfor
            </tr>
            <tr class="text-center">
                @for($i = 1; $i <= 6; $i++)
                    @for($j=1; $j <=5; $j++)
                    <th>{{ $j }}</th>
                    @endfor
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
                    })->take(5);
                    @endphp

                    @foreach($nilaiBulan as $n)
                    <td>{{ $n->nilai }}</td>
                    @endforeach

                    {{-- Jika datanya kurang dari 5, isi kosong --}}
                    @for($i = $nilaiBulan->count(); $i < 5; $i++)
                        <td>-</td>
                        @endfor
                        @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</div>