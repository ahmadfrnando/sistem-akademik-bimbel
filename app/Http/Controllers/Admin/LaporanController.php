<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Tugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetakSiswa()
    {
        $siswa = Siswa::all();

        $pdf = Pdf::loadView('pages.admin.siswa.laporan', compact('siswa'))
            ->setPaper('A4', 'portrait'); // atau 'landscape'

        return $pdf->stream('laporan-siswa.pdf');
    }

    public function cetakNilai($semester = null)
    {
        $siswa = Siswa::with('nilai')->get();
        $tugas = Tugas::with('jadwal')->get();
        $nilai = Nilai::all();

        $pdf = Pdf::loadView('pages.admin.nilai.laporan-nilai-semester-' . $semester, compact('siswa', 'tugas', 'nilai', 'semester'))
            ->setPaper('A4', 'landscape'); // atau 'landscape'

        return $pdf->stream('laporan-nilai.pdf');
    }
}
