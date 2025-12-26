<div class="d-flex align-items-center gap-2">
    <button onClick="window.location.href='{{ route('siswa.tugas.show', $row['id']) }}'" class="btn btn-outline-warning btn-sm text-nowrap" data-toggle="tooltip" data-placement="bottom" title="Detail" {{ !$row['isActive'] ? 'disabled' : '' }}>Kerjakan Soal</button>
    @if($row['isResult'])
        <button onClick="window.location.href='{{ route('siswa.tugas.show.submissions', [$row['id'], $row['siswa_id']]) }}'" class="btn btn-outline-primary btn-sm text-nowrap" data-toggle="tooltip" data-placement="bottom" title="Detail">Lihat Jawaban</button>
    @endif
</div>