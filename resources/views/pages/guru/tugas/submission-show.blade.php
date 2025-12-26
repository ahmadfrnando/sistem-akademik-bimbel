@extends('pages.layouts.guru')

@section('title', 'Detail Tugas')
@section('description', 'Detail tugas yang telah diserahkan oleh siswa.')

@section('content')
<section class="section">
    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('guru.tugas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Tugas
        </a>
    </div>

    <!-- Card Informasi Tugas -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary">
            <h4 class="mb-0 text-light"><i class="bi bi-clipboard-check me-2"></i>Informasi Tugas</h4>
        </div>
        <div class="card-body mt-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary mb-3">{{ $tugas->judul }}</h5>
                    <div class="mb-2">
                        <i class="bi bi-person-fill text-muted me-2"></i>
                        <strong>Nama Siswa:</strong> 
                        <span class="text-muted">{{ $siswa->nama ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-calendar-event text-muted me-2"></i>
                        <strong>Tanggal:</strong> 
                        <span class="text-muted">{{ \Carbon\Carbon::parse($tugas->jadwal->tanggal ?? '')->format('d-m-Y') }}</span>
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-clock text-muted me-2"></i>
                        <strong>Waktu:</strong> 
                        <span class="text-muted">
                            {{ \Carbon\Carbon::parse($tugas->jadwal->jam_mulai ?? '')->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($tugas->jadwal->jam_selesai ?? '')->format('H:i') }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="text-secondary mb-3"><i class="bi bi-graph-up me-2"></i>Hasil Penilaian</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Bobot:</span>
                                <strong class="text-primary">{{ $nilaiSiswa->total_bobot ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Skor:</span>
                                <strong class="text-success">{{ $nilaiSiswa->total_skor ?? 0 }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Nilai Akhir:</h6>
                                <h3 class="mb-0 text-primary">
                                    <span class="badge bg-primary fs-5">{{ $nilaiSiswa->nilai ?? 0 }}</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Jawaban Siswa -->
    <div class="card shadow-sm">
        <div class="card-header bg-success">
            <h5 class="mb-0 text-light"><i class="bi bi-list-check me-2"></i>Jawaban yang Telah Disimpan</h5>
        </div>
        <div class="card-body mt-4">
            @if($pertanyaan->isEmpty())
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>Belum ada jawaban yang tersimpan.
                </div>
            @else
                @foreach($pertanyaan as $index => $p)
                @php
                    $jawaban = $p->jawaban_pilihan_ganda_siswa->first();
                    $isAnswered = $jawaban !== null;
                    $isCorrect = $jawaban && $jawaban->is_correct;
                    $skorDiperoleh = $isCorrect ? $p->bobot : 0;
                @endphp
                <div class="card mb-3 border-{{ $isCorrect ? 'success' : ($isAnswered ? 'danger' : 'secondary') }}">
                    <div class="card-header bg-{{ $isCorrect ? 'success' : ($isAnswered ? 'danger' : 'secondary') }} bg-opacity-10">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <span class="badge bg-secondary me-2">Soal #{{ $index + 1 }}</span>
                                <strong class="d-block mt-2">{{ $p->pertanyaan }}</strong>
                            </div>
                            <div class="text-end ms-3">
                                <span class="badge bg-{{ $isCorrect ? 'success' : ($isAnswered ? 'danger' : 'secondary') }} fs-6">
                                    <i class="bi bi-{{ $isCorrect ? 'check-circle' : ($isAnswered ? 'x-circle' : 'dash-circle') }} me-1"></i>
                                    {{ $skorDiperoleh }}/{{ $p->bobot }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%" class="text-center">#</th>
                                        <th style="width:10%" class="text-center">Opsi</th>
                                        <th>Jawaban</th>
                                        <th style="width:15%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($p->opsi as $idx => $opsi)
                                    @php
                                        $isSelected = $jawaban && $jawaban->opsi_pertanyaan_id == $opsi->id;
                                        $rowClass = '';
                                        if ($isSelected) {
                                            $rowClass = $opsi->is_correct ? 'table-success' : 'table-danger';
                                        } elseif ($opsi->is_correct) {
                                            $rowClass = 'table-info';
                                        }
                                    @endphp
                                    <tr class="{{ $rowClass }}">
                                        <td class="text-center">
                                            @if($isSelected)
                                                <i class="bi bi-arrow-right-circle-fill text-{{ $opsi->is_correct ? 'success' : 'danger' }}"></i>
                                            @else
                                                {{ $idx + 1 }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <strong class="badge bg-secondary">{{ strtoupper($opsi->label) }}</strong>
                                        </td>
                                        <td>
                                            {{ $opsi->text }}
                                            @if($isSelected)
                                                <span class="badge bg-{{ $opsi->is_correct ? 'success' : 'danger' }} ms-2">
                                                    <i class="bi bi-hand-index-thumb me-1"></i>Dipilih
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($opsi->is_correct)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Benar
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Salah
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endsection