@if($row['tanggal'] <= now() && $row['jam_selesai'] < now())
    <span class="badge bg-danger">Closed</span>
@else
    <span class="badge bg-success">Opened</span>
@endif