<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\RefKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $dataUser;
    protected $siswa;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserGuru();
            return $next($request);
        });
        $this->siswa = new Siswa();

    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->siswa->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('pages.guru.siswa.index');
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
    public function show(Request $request, string $id)
    {
        if ($request->ajax()) {
            $data = $this->siswa->select('*')->where('kelas_id', $id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        $kelas = RefKelas::findOrFail($id);
        return view('pages.guru.siswa.show', compact('kelas'));
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
