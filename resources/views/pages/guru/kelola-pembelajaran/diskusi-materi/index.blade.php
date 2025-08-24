@extends('pages.layouts.guru')

@section('title', 'Diskusi Materi Pembelajaran')
@section('description', 'Berikut adalah semua diskusi materi pembelajaran yang telah tercatat.')

@section('content')
<section class="section">
    <a href="{{ route('guru.kelola-pembelajaran.show', $dataMateri->kelas_id) }}" class="btn mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 row">
                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <h3 class="mb-0 fw-bolder">{{ $dataMateri->nama_materi }}</h3>
                            <span class="mb-0 fw-bolder text-muted">Deskripsi: {{ $dataMateri->deskripsi }}</span>
                            <div class="d-flex gap-4 mt-2 align-items-center justify-content-start">
                                <div>
                                    <i class="ti ti-cake text-muted"></i>
                                    <span class="text-muted"><b>Total Siswa:</b> {{ $dataMateri->kelas->siswa->count() ?? 0 }} Siswa</span>
                                </div>
                                <div>
                                    <i class="ti ti-cake text-muted"></i>
                                    <span class="text-muted"><b>Total Siswa Yang Sudah Mengerjakan:</b> {{ $dataMateri->tanggapanSiswaCount() ?? 0 }} Siswa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($tanggapans->count())
                @foreach($tanggapans as $tanggapan)
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <h5 class="mb-0">{{ $tanggapan->siswa->nama ?? '-' }}</h5>
                            <small class="text-muted">{{ $tanggapan->created_at->diffForHumans() }}</small>
                            <span class="text-muted">{{ $tanggapan->tanggapan ?? '-' }}</span>
                        </div>
                        @if(!empty($tanggapan->file))
                        <button type="button" id="file" data-file="{{ $tanggapan->file }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#modalShowFile">
                            <i class="bi bi-paperclip"></i> Lihat Lampiran
                        </button>
                        @endif
                    </li>
                </ul>
                <hr>
                @endforeach
                @if(method_exists($tanggapans, 'links'))
                <div class="p-3">
                    {{ $tanggapans->links('vendor.pagination.bootstrap-5') }}
                </div>
                @endif
                @else
                <div class="p-4 text-center text-muted">Belum ada tanggapan</div>
                @endif
            </div>
        </div>
    </div>
    @include('pages.guru.kelola-pembelajaran.diskusi-materi._show')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#file', function() {
            $('#modalShowFile').find('.modal-title').html('Lihat Lampiran');
            let file = $(this).data('file');
            let url = "{{ asset('storage') }}/" + file;
            $('#showFile').attr('data', url);
        });
    })
</script>
@endpush
@endsection