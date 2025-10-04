<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// start admin
// admin > dashboard
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Pages', route('admin.dashboard'));
});

// admin > siswa
Breadcrumbs::for('admin.siswa.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Data Master Siswa', route('admin.siswa.index'));
});

// admin > guru
Breadcrumbs::for('admin.guru.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Data Master Guru', route('admin.guru.index'));
});

// admin > jadwal
Breadcrumbs::for('admin.jadwal.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Jadwal', route('admin.jadwal.index'));
});

// admin > pembelajaran
Breadcrumbs::for('admin.pembelajaran.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Pembelajaran', route('admin.pembelajaran.index'));
});

// admin > akun
Breadcrumbs::for('admin.user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Update Akun', route('admin.user.index'));
});

// admin > nilai
Breadcrumbs::for('admin.nilai.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Nilai Siswa', route('admin.nilai.index'));
});

// admin > nilai > show
Breadcrumbs::for('admin.nilai.show', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.nilai.index');
    $trail->push('Detail', route('admin.nilai.show', 'id'));
});

// end admin

// start guru
// guru > dashboard
Breadcrumbs::for('guru.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Pages', route('guru.dashboard'));
});

// guru > data siswa 
Breadcrumbs::for('guru.siswa.index', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Daftar Siswa', route('guru.siswa.index'));
});

// guru > data jadwal 
Breadcrumbs::for('guru.jadwal.index', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Daftar Jadwal', route('guru.jadwal.index'));
});

// guru > pembelajaran 
Breadcrumbs::for('guru.pembelajaran.index', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Pembelajaran', route('guru.pembelajaran.index'));
});

// guru > tugas 
Breadcrumbs::for('guru.tugas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Tugas', route('guru.tugas.index'));
});

// guru > tugas > show 
Breadcrumbs::for('guru.tugas.show', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.tugas.index');
    $trail->push('Input Tugas', route('guru.tugas.show', 'id'));
});

// guru > akun
Breadcrumbs::for('guru.user.edit-username', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Update Username', route('guru.user.edit-username'));
});

// guru > akun
Breadcrumbs::for('guru.user.edit-password', function (BreadcrumbTrail $trail) {
    $trail->parent('guru.dashboard');
    $trail->push('Update Password', route('guru.user.edit-password'));
});

// end guru

// start siswa
// dashboard
Breadcrumbs::for('siswa.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Pages', route('siswa.dashboard'));
});

// siswa > tugas
Breadcrumbs::for('siswa.tugas.index', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa.dashboard');
    $trail->push('Daftar Tugas', route('siswa.tugas.index'));
});

// siswa > tugas >show
Breadcrumbs::for('siswa.tugas.show', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa.tugas.index');
    $trail->push('Daftar Tugas', route('siswa.tugas.show', 'id'));
});

// siswa > tugas > materi
Breadcrumbs::for('siswa.tugas.list-materi', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa.tugas.index');
    $trail->push('Materi', route('siswa.tugas.list-materi', 'mapel_id'));
});

// siswa > tugas > materi > detail materi
Breadcrumbs::for('siswa.tugas.show-materi', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa.tugas.list-materi');
    $trail->push('Detail Materi', route('siswa.tugas.show-materi', 'materi_id'));
});

// siswa > pembelajaran
Breadcrumbs::for('siswa.pembelajaran.index', function (BreadcrumbTrail $trail) {
    $trail->parent('siswa.dashboard');
    $trail->push('Daftar Pembelajaran', route('siswa.pembelajaran.index'));
});

// end siswa