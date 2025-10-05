<?php

namespace App\Http\Controllers\Siswa;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Tugas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    protected $dataUser;
    protected $tugas;
    protected $nilai;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserSiswa();
            $this->nilai = Nilai::where('siswa_id', $this->dataUser->id);
            $this->tugas = Tugas::where('is_draft', false);
            return $next($request);
        });
    }
    public function cetakNilai($semester = null)
    {
        $siswa = $this->dataUser->load('nilai.tugas.jadwal');

        $pdf = Pdf::loadView('pages.siswa.nilai.laporan-nilai-semester-' . $semester, compact('siswa'))
            ->setPaper('A4', 'landscape'); // atau 'landscape'

        return $pdf->stream('laporan-nilai-siswa.pdf');
    }
}
