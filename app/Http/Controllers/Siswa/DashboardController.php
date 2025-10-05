<?php

namespace App\Http\Controllers\Siswa;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $dataUser;
    protected $tugas;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserSiswa();
            return $next($request);
        });
    }
    
    public function index()
    {
        $statsOverview = [
            'tugas_selesai' => $this->dataUser->tugasSelesai()->count(),
            'tugas_belum_selesai' => $this->dataUser->tugasBelumSelesai()->count(),
            'pembelajaran_aktif' => $this->dataUser->pembelajaranAktif()->count(),
            'nilai_tertinggi' => $this->dataUser->nilai()->max('nilai'),
            'profile_siswa' => $this->dataUser,
        ];

        $tableTugas = $this->dataUser->tugasBelumSelesai()->get();
        $tablePembelajaran = $this->dataUser->pembelajaranAktif()->with('jadwal')->get();
        return view('pages.siswa.index', compact('statsOverview', 'tableTugas', 'tablePembelajaran'));
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
