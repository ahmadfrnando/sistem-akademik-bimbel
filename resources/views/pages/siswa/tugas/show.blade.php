@extends('pages.layouts.siswa')

@section('title', 'Kerjakan Tugas')
@section('description', 'Jawablah semua pertanyaan berikut dengan memilih salah satu jawaban.')

@section('content')
<section class="section">
    <a href="{{ route('siswa.tugas.index') }}" class="btn mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Kerjakan Soal Pilihan Ganda</h5>
        </div>
        <div class="card-body">
            @if($data->pertanyaan->count() == 0)
            <p class="text-muted">Belum ada pertanyaan yang disimpan.</p>
            @elseif($data->pertanyaan->pluck('jawaban_pilihan_ganda_siswa')->flatten()->where('siswa_id', $siswa_id)->count() > 0)
            <p class="text-muted">Tugas sudah dijawab.</p>
            @else
            <form id="formSoal" method="POST" action="{{ route('siswa.jawaban-pg.store') }}">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa_id }}">
                <input type="hidden" name="tugas_id" value="{{ $data->id }}">

                @foreach($data->pertanyaan as $p)
                <div class="mb-4">
                    <h6>{{ $loop->iteration }}. {{ $p->pertanyaan }}
                        <span class="badge bg-secondary">Bobot: {{ $p->bobot }}</span>
                    </h6>
                    @foreach($p->opsi as $opsi)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="jawaban[{{ $p->id }}]"
                            id="pertanyaan_{{ $p->id }}_opsi_{{ $opsi->id }}"
                            value="{{ $opsi->id }}"
                            required>
                        <label class="form-check-label" for="pertanyaan_{{ $p->id }}_opsi_{{ $opsi->id }}">
                            {{ strtoupper($opsi->label) }}. {{ $opsi->text }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <hr>
                @endforeach
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</section>
@push('scripts')
<script type="text/javascript">
    let formSelector = '#formSoal';
    let actionUrl = "{{ route('siswa.jawaban-pg.store') }}";
    let successMessage = 'Data berhasil disimpan!';
    var redirectUrl = "{{ route('siswa.tugas.show', $data->id) }}";
    submitFormAjax(formSelector, actionUrl, successMessage, redirectUrl);
</script>
@endpush
@endsection