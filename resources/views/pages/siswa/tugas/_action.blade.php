<div class="d-flex align-items-center">
    <button onClick="window.location.href='{{ route('siswa.tugas.show', $row['id']) }}'" class="btn btn-outline-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Detail" {{ $row['dateTime'] <= now() ? 'disabled' : '' }}>Kerjakan Soal</button>
</div>