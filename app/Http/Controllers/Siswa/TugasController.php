<?php

namespace App\Http\Controllers\Siswa;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\RefKategoriTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TugasController extends Controller
{
    protected $dataUser;
    protected $tugas;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserSiswa();
            $this->tugas = Tugas::where('is_draft', false);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->tugas->with(['jadwal', 'kategori_tugas', 'guru'])->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jam', function ($row) {
                    $jamMulai = \Carbon\Carbon::parse($row->jadwal->jam_mulai)->format('H:i');
                    $jamSelesai = \Carbon\Carbon::parse($row->jadwal->jam_selesai)->format('H:i');
                    return $jamMulai . ' - ' . $jamSelesai;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->jadwal->tanggal ?? '-';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->kategori_tugas->kategori ?? '-';
                })
                ->addColumn('guru', function ($row) {
                    return $row->guru->nama ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $row = [
                        'tanggal' => $row->jadwal->tanggal,
                        'jam_selesai' => $row->jadwal->jam_selesai
                    ];
                    return view('pages.siswa.tugas._status')->with('row', $row)->render();
                })
                ->addColumn('action', 'pages.siswa.tugas._action')
                ->rawColumns(['status', 'action'])
                ->filterColumn('guru', function ($query, $value) {
                    $query->whereHas('guru', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.siswa.tugas.index', [
            'siswa_id' => $this->dataUser->id,
        ]);
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
        $data = $this->tugas->findOrFail($id);
        return view('pages.siswa.tugas.show', [
            'data' => $data,
            'siswa_id' => $this->dataUser->id
        ]);
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
