@if($responses->count())
<ul class="list-group list-group-flush">
    @foreach($responses as $res)
    <li class="list-group-item">
        <div class="d-flex justify-content-between">
            <div>
                <h6 class="mb-1">{{ $res->siswa->nama ?? 'Siswa' }}</h6>
                <small class="text-muted">{{ optional($res->created_at)->diffForHumans() }}</small>
            </div>
        </div>
        <div class="mt-2">{!! nl2br(e($res->tanggapan)) !!}</div>
        @if(!empty($res->file))
        <div class="mt-2">
            <button type="button" id="file" data-file="{{ $res->file }}" class="btn btn-sm btn-outline-secondary"  data-bs-toggle="modal"
                data-bs-target="#modalShowFile">
                <i class="bi bi-paperclip"></i> Lihat Lampiran
            </button>
        </div>
        @endif
    </li>
    @endforeach
</ul>

@if(method_exists($responses, 'links'))
<div class="p-3">
    {{ $responses->links('vendor.pagination.bootstrap-5') }}
</div>
@endif

@else
<div class="p-4 text-center text-muted">Belum ada tanggapan. Jadilah yang pertama.</div>
@endif