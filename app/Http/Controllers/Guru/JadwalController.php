<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pembelajaran;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    protected $dataUser;
    protected $jadwal;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserGuru();
            $this->jadwal = Jadwal::where('guru_id', $this->dataUser->id);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $jadwalIdExists = Pembelajaran::where('guru_id', $this->dataUser->id)->get()->pluck('jadwal_id')->toArray();
        if ($request->ajax()) {
            $data = $this->jadwal->whereNotIn('id', $jadwalIdExists)->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('jam', function ($row) {
                    $jamMulai = \Carbon\Carbon::parse($row->jam_mulai)->format('H:i');
                    $jamSelesai = \Carbon\Carbon::parse($row->jam_selesai)->format('H:i');
                    return $jamMulai . ' - ' . $jamSelesai;
                })
                ->addColumn('status', function ($row) {
                    $row = [
                        'isTugas' => Tugas::where('guru_id', $this->dataUser->id)->where('jadwal_id', $row->id)->exists(),
                        'isPembelajaran' => Pembelajaran::where('guru_id', $this->dataUser->id)->where('jadwal_id', $row->id)->exists()
                    ];
                    return view('pages.guru.jadwal._status')->with('row', $row)->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }
        return view('pages.guru.jadwal.index');
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
