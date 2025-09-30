<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr class="text-center">
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA</th>
                @for($bulan = 1; $bulan <= 6; $bulan++)
                    <th colspan="5">Nilai {{ $bulan == 1 ? 'Januari' : ( $bulan == 2 ? 'Februari' : ( $bulan == 3 ? 'Maret' : ( $bulan == 4 ? 'April' : ( $bulan == 5 ? 'Mei' : ( $bulan == 6 ? 'Juni' : '' ) ) ) ) ) }}</th>
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
                @for($bulan = 1; $bulan <= 6; $bulan++)
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