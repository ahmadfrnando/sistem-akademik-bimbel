<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Imports\TestsImport;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $guru;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->guru = Pengguna::getUserGuru();
            return $next($request);
        });
    }
    public function index()
    {   
        $statsOverview = [
            'total_siswa' => Siswa::count(),
            'jadwal_tersedia' => $this->guru->getCountJadwalTersedia(),
            'pembelajaran_berjalan' => $this->guru->getPembelajaranBerjalan()->count(),
            'tugas_berjalan' => $this->guru->getTugasBerjalan()->count(),
            'profile_guru' => $this->guru
        ];

        $tableSiswa = Siswa::all();

        $tableSiswaPalingAktif = $this->guru->getSiswaPalingAktif();

        $tablePembelajaranTugasAktif = [
            'pembelajaran' => $this->guru->getPembelajaranBerjalan(),
            'tugas' => $this->guru->getTugasBerjalan()
        ];

        return view('pages.guru.index', compact('statsOverview', 'tableSiswa', 'tableSiswaPalingAktif', 'tablePembelajaranTugasAktif'));
    }

    // public function total

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function import()
    // {   
    //     return Excel::import(new TestsImport, public_path('sample/tests-import.xlsx'));
    // }
}
