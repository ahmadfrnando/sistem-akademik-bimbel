@extends('pages.layouts.guru')

@section('title', 'Dashboard')
@section('deskription', '')

@section('content')
<section class="row">
    <div class="col-12 col-lg-9">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Siswa</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['total_siswa'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon blue mb-2">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Jadwal Tersedia</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['jadwal_tersedia'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldAdd-User"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pembelajaran Berjalan</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['pembelajaran_berjalan'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon red mb-2">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Tugas Berjalan</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['tugas_berjalan'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Semua Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-lg">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tableSiswa as $s)
                                    <tr>
                                        <td class="col-3">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold mb-0">{{ $s->nama }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <p class=" mb-0">{{ $s->user->username ?? '-'}}</p>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Pembelajaran dan Tugas Aktif</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-lg">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tablePembelajaranTugasAktif['pembelajaran'] as $p)
                                    <tr>
                                        <td class="col-3">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold mb-0">{{ $p->judul }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <a href="javascript:void(0)" onClick="showFunc('{{ $p->file }}')" class="btn btn-lihat btn-warning btn-sm"><i class="bi bi-file-earmark-check me-1"></i>Lihat Materi</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach($tablePembelajaranTugasAktif['tugas'] as $t)
                                    <tr>
                                        <td class="col-3">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold mb-0">{{ $t->judul }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <a href="{{ route('guru.tugas.show', $t->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Lihat Tugas</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-body py-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img src="/assets/compiled/jpg/1.jpg" alt="Face 1">
                    </div>
                    <div class="ms-3 name">
                        <h5 class="font-bold">{{ $statsOverview['profile_guru']->nama ?? '-' }}</h5>
                        <h6 class="text-muted mb-0">{{ $statsOverview['profile_guru']->user->username ?? '-' }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Siswa Paling Aktif</h4>
            </div>
            <div class="card-content pb-4">
                @foreach($tableSiswaPalingAktif as $siswa)
                <div class="recent-message d-flex px-4 py-3">
                    <div class="name">
                        <h5 class="mb-1">{{ $siswa->nama ?? '-' }}</h5>
                        <h6 class="text-muted mb-0">{{ $siswa->user->username ?? '-' }}</h6>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('pages.guru._show_pembelajaran')
</section>
@push('scripts')
<script type="text/javascript">
    function showFunc(fileParams) {
        $('#modalShow').modal('show');
        var file = fileParams;
        $('#modalShowFile').find('.modal-title').html('Lihat Lampiran');
        let url = "{{ asset('storage') }}/" + file;
        $('#showFile').attr('data', url);
        $('#modalShowFile').modal('show');
    }
</script>
@endpush
@endsection