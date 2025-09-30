@if($row['isTugas'] > 0 || $row['isPembelajaran'] > 0)
    <span class="badge bg-success">Sudah dijadwalkan</span>
@else
    <span class="badge bg-danger">Belum dijadwalkan</span>
@endif