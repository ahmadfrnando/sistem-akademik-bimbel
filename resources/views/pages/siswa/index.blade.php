@extends('pages.layouts.siswa')

@section('title', 'Dashboard')
@section('deskription', '')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldTick-Square"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Tugas Selesai</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['tugas_selesai'] }}</h6>
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
                                    <i class="iconly-boldTime-Circle"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Tugas Berjalan</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['tugas_belum_selesai'] }}</h6>
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
                                    <i class="iconly-boldPaper"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pembelajaran Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['pembelajaran_aktif'] }}</h6>
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
                                    <i class="iconly-boldStar"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Nilai Tertinggi
                                    <button type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Semester Berjalan" style="border: none!important; background: none!important; padding: 0!important; cursor: pointer!important;">
                                        <i class="bi bi-info-circle ms-2"></i>
                                    </button>
                                </h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['nilai_tertinggi'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="/assets/compiled/jpg/1.jpg" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ $statsOverview['profile_siswa']->nama ?? '-' }}</h5>
                                <h6 class="text-muted mb-0">{{ $statsOverview['profile_siswa']->user->username ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Tugas Aktif</h4>
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
                                    @foreach ($tableTugas as $tugas)
                                    <tr>
                                        <td class="col-3">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold mb-0">{{ $tugas->judul }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <a href="{{ route('siswa.tugas.show', $tugas->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Kerjakan </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @foreach ($tablePembelajaran as $pembelajaran)
                                    <tr>
                                        <td class="col-3">
                                            <div class="d-flex align-items-center">
                                                <p class="font-bold mb-0">{{ $pembelajaran->judul }}</p>
                                            </div>
                                        </td>
                                        <td class="col-auto">
                                            <a href="javascript:void(0)" onClick="showFunc('{{ $pembelajaran->file }}')" class="btn btn-lihat btn-primary btn-sm"><i class="bi bi-file-earmark-check me-1"></i>Lihat</a>
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
    @include('pages.siswa._show_pembelajaran')
</section>
@push('scripts')
<script type="text/javascript">
    // If you want to use tooltips in your project, we suggest initializing them globally
    // instead of a "per-page" level.
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    }, false);

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