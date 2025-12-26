@extends('pages.layouts.admin')

@section('title', 'Input Soal Tugas')
@section('description', 'Form untuk menambahkan soal pilihan ganda.')

@section('content')
<section class="section">
    <a href="{{ route('admin.tugas.index') }}" class="btn mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h3 class="mb-1 fw-bolder">{{ $data->judul }}</h3>
                    <div class="text-muted">
                        Tanggal: {{ \Carbon\Carbon::parse($data->jadwal->tanggal ?? '')->format('d-m-Y') }}
                    </div>
                    <div class="text-muted">
                        Jadwal: {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai ?? '')->format('H:i') }} - {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai ?? '')->format('H:i') }}
                    </div>
                    <div class="small text-muted mt-2">
                        Keterangan: {{ $data->keterangan ?: '-' }}
                    </div>
                </div>
                @if($data->is_draft == true && $data->pertanyaan->count() > 0)
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="javascript:void(0)" onClick="sendFunc({{ $data->id }})" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Kirim Tugas">
                        <i class="bi bi-send-check"></i> Kirim Tugas
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if($data->is_draft == true)
        <p>soal belum di buat</p>
    @endif
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pertanyaan yang Telah Disimpan</h5>
        </div>
        <div class="card-body">
            @if($data->pertanyaan->isEmpty())
            <p class="text-muted">Belum ada pertanyaan yang disimpan.</p>
            @else
            @foreach($data->pertanyaan as $p)
            <div class="card mb-3 border">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>Pertanyaan:</strong> {{ $p->pertanyaan }}</span>
                    <span class="badge bg-primary">Bobot: {{ $p->bobot }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:10%">Label</th>
                                <th>Opsi Jawaban</th>
                                <th style="width:15%">Kebenaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($p->opsi as $idx => $opsi)
                            <tr>
                                <td>{{ $idx+1 }}</td>
                                <td>{{ strtoupper($opsi->label) }}</td>
                                <td>{{ $opsi->text }}</td>
                                <td>
                                    @if($opsi->is_correct)
                                    <span class="badge bg-success">Benar</span>
                                    @else
                                    <span class="badge bg-danger">Salah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection