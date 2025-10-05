<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Pembelajaran;
use App\Models\RefKelas;
use App\Models\RefMapel;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statsOverview = [
            'total_siswa' => Siswa::count(),
            'tugas_berjalan' => $this->getTugasBerjalan()->count(),
            'pembelajaran_berjalan' => $this->getPembelajaranBerjalan()->count(),
            'profile_admin' => Auth::user(),
        ];

        $tablePembelajaranTugasAktif = [
            'pembelajaran' => $this->getPembelajaranBerjalan(),
            'tugas' => $this->getTugasBerjalan()
        ];

        return view('pages.admin.index', compact('statsOverview', 'tablePembelajaranTugasAktif'));
    }

    private function getTugasBerjalan()
    {
        return Tugas::whereIn('jadwal_id', $this->getJadwalBerjalan()->pluck('id'))->get();
    }

    private function getPembelajaranBerjalan()
    {
        return Pembelajaran::whereIn('jadwal_id', $this->getJadwalBerjalan()->pluck('id'))->get();
    }

    private function getJadwalBerjalan()
    {
        return Jadwal::where(function ($q) {
            $q->where('tanggal', '>', now()->toDateString())
                ->orWhere(function ($q2) {
                    $q2->where('tanggal', now()->toDateString())
                        ->where('jam_selesai', '>=', now()->format('H:i'));
                });
        })
            ->get();
    }

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
}
