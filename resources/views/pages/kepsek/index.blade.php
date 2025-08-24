@extends('pages.layouts.kepsek')

@section('title', 'Dashboard')
@section('deskription', '')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img src="/assets/compiled/jpg/1.jpg" alt="Face 1">
                    </div>
                    <div class="ms-3 name">
                        <h5 class="font-bold">{{ $model->nama }} ({{ $model->user->username ?? '-' }})</h5>
                        <h6 class="text-muted mb-0">{{ $model->user->role->role_name ?? '-' }} - {{ $model->kelas->nama_kelas ?? '-' }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Pembelajaran Aktif</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Materi</th>
                                <th>Kelas</th>
                                <th>Total Siswa Menjawab</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($modelMateri->count())
                                @foreach($modelMateri as $key => $materi)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        {{ $materi->nama_materi }}
                                    </td>
                                    <td>
                                        {{ $materi->kelas->nama_kelas ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $materi->tanggapanSiswaCount() ?? 0 }} Siswa
                                    </td>
                                    <td>
                                        <a href="{{ route('siswa.tugas.show-materi', $materi->id) }}" class="btn btn-outline-primary d-inline-flex"><i class="bi bi-chat me-1"></i>Lihat Diskusi</a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Belum ada materi</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection