@if($row <= now()->format('Y-m-d H:i'))
    <span class="badge bg-danger">Closed</span>
@else
    <span class="badge bg-success">Opened</span>
@endif