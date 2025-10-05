<?php

namespace App\Http\Controllers\Siswa;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Tugas;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function index(Request $request)
    {
        $siswa = $this->dataUser->load('nilai.tugas.jadwal');

        return view('pages.siswa.nilai.index', compact('siswa'));
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
