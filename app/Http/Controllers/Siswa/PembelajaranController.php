<?php

namespace App\Http\Controllers\Siswa;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Pembelajaran;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataUser;
    protected $pembelajaran;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserSiswa();
            $this->pembelajaran = Pembelajaran::with(['jadwal', 'guru']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->pembelajaran->orderBy('created_at', 'desc')->select('*');
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
                ->addColumn('guru', function ($row) {
                    return $row->guru->nama ?? '-';
                })
                ->addColumn('status', function ($row) {
                    $row = [
                        'id' => $row->id,
                        'dateTime' => $row->jadwal->tanggal . ' ' . $row->jadwal->jam_selesai,
                    ];
                    return view('pages.siswa.pembelajaran._status')->with('row', $row)->render();
                })
                ->addColumn('action', function ($row) {
                     $row = [
                        'id' => $row->id,
                        'dateTime' => $row->jadwal->tanggal . ' ' . $row->jadwal->jam_selesai,
                        'file' => $row->file,
                    ];
                    return '<button onClick="showFunc(\'' . $row['file'] . '\')" class="btn btn-lihat btn-primary btn-sm" ' . ($row['dateTime'] <= now() ? 'disabled' : '') . '><i class="bi bi-file-earmark-check me-1"></i>Lihat</button>';
                })
                ->rawColumns(['status', 'action'])
                ->filterColumn('guru', function ($query, $value) {
                    $query->whereHas('guru', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.siswa.pembelajaran.index', [
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
