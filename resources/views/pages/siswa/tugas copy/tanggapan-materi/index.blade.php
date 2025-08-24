@extends('pages.layouts.siswa')

@section('title', 'Diskusi Materi Pembelajaran')
@section('description', 'Berikut adalah semua diskusi materi pembelajaran yang telah tercatat.')

@section('content')
<section class="section">
    <a href="{{ route('siswa.tugas.list-materi', $data->mapel_id) }}" class="btn mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <h3 class="mb-1 fw-bolder">{{ $data->nama_materi }}</h3>
                        <div class="text-muted">
                            Mapel: {{ $data->mapel->nama_mapel ?? '-' }}
                        </div>
                        <div class="small text-muted mt-2">
                            Deskripsi: {{ $data->deskripsi ?: '-' }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        @if(!empty($data->file_materi))
                        <button type="button" id="file" data-file="{{ $data->file_materi }}" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#modalShowFile">
                            <i class="bi bi-paperclip"></i> Lihat Materi
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">Beri Tanggapan</div>
            <div class="card-body">
                <form id="createForm">
                    @csrf
                    <input type="hidden" name="materi_id" value="{{ $data->id }}">
                    <input type="hidden" name="kelas_id" value="{{ $data->kelas_id }}">
                    <input type="hidden" name="guru_id" value="{{ $data->guru_id }}">
                    <div class="mb-3">
                        <label for="tanggapan" class="form-label">Tulis komentar atau jawaban</label>
                        <textarea
                            name="tanggapan"
                            id="tanggapan"
                            rows="4"
                            class="form-control @error('tanggapan') is-invalid @enderror"
                            placeholder="Tulis tanggapanmu di sini" required>{{ old('tanggapan') }}</textarea>
                        @error('tanggapan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Lampiran</label>
                        <input
                            name="file"
                            id="file"
                            type="file"
                            class="form-control @error('file') is-invalid @enderror" />
                        <small>Ukuran file maksimal 2mb</small>
                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card" id="result">
            <div class="card-header">
                Diskusi
                <span class="badge bg-danger ms-2">
                    {{ isset($responses) ? ($responses->total() ?? $responses->count()) : 0 }}
                </span>
            </div>
            <div class="card-body p-0">
                @include('pages.siswa.tugas.tanggapan-materi._komentar')
            </div>
        </div>
    </div>
    @include('pages.siswa.tugas.tanggapan-materi._show')
</section>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        let content = '#result .card-body';
        let formSelector = '#createForm';
        let actionUrl = "{{ route('siswa.tugas.tanggapan-materi.store', $data->id) }}";
        let reloadUrl = "{{ route('siswa.tugas.tanggapan-materi.load', $data->id) }}";
        submitFormUploadAjaxNoReload(formSelector, actionUrl, content, reloadUrl);

        $(document).on('click', '#file', function() {
            $('#modalShowFile').find('.modal-title').html('Lihat Lampiran');
            let file = $(this).data('file');
            let url = "{{ asset('storage') }}/" + file;
            $('#showFile').attr('data', url);
        });
    });
</script>
@endpush
@endsection