@extends('pages.layouts.admin')

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
                                    <i class="iconly-boldShow"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Siswa</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['total_siswa'] }}</h6>
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
                                <h6 class="text-muted font-semibold">Tugas Berjalan</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['tugas_berjalan'] }}</h6>
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
                                <h6 class="text-muted font-semibold">Pemebelajaran Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $statsOverview['pembelajaran_berjalan'] }}</h6>
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
                                <h5 class="font-bold">{{ $statsOverview['profile_admin']->name }}</h5>
                                <h6 class="text-muted mb-0">{{ $statsOverview['profile_admin']->username }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Tugas dan Pembalajaran Berjalan</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tablePembelajaranTugasAktif['pembelajaran'] as $p)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0">{{ $p->judul }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($tablePembelajaranTugasAktif['tugas'] as $t)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0">{{ $t->judul }}</p>
                                        </div>
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
</section>
@endsection