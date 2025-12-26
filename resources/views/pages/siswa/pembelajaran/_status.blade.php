@if($row['dateTime'] <= now())
    <span class="badge bg-danger">Closed</span>
@else
    <span class="badge bg-success">Opened</span>
@endif