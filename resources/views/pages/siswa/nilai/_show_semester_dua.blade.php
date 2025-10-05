<div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead>
            <tr class="text-center bg-primary">
                <th>Bulan</th>
                <th>Nilai Rata - Rata</th>
            </tr>
        </thead>
        <tbody>
            @for($bulan = 7; $bulan <= 12; $bulan++)
                @php
                    // Ambil nilai untuk bulan ke-X
                    $nilaiBulan = $siswa->nilai->filter(function($nilai) use ($bulan) {
                        return optional($nilai->tugas->jadwal)->tanggal &&
                            \Carbon\Carbon::parse($nilai->tugas->jadwal->tanggal)->month == $bulan;
                    });

                    $rata2 = $nilaiBulan->count() > 0
                        ? number_format($nilaiBulan->avg('nilai'), 2, '.', '.')
                        : '-';
                @endphp
                <tr>
                    <td>
                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    </td>
                    <td class="text-center">{{ $rata2 }}</td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
