<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\TugasRequest;
use App\Imports\PertanyaanEssayImport;
use App\Imports\PertanyaanImport;
use App\Models\Nilai;
use App\Models\RefKategoriTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TugasController extends Controller
{
    protected $dataUser;
    protected $tugas;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserGuru();
            $this->tugas = Tugas::where('guru_id', $this->dataUser->id);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // dd(now());
        if ($request->ajax()) {
            $data = $this->tugas->orderBy('created_at', 'desc')->select('*');
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
                ->addColumn('total_jawaban', function ($row) {
                    return $row->tugas ? $row->tugas->nilai->count() : 0;
                })
                ->addColumn('status', function ($row) {
                    $dateTime = $row->jadwal->tanggal . ' ' . $row->jadwal->jam_selesai;
                    return view('pages.guru.tugas._status')->with('row', $dateTime)->render();
                })
                ->addColumn('action', 'pages.guru.tugas._action')
                ->rawColumns(['action', 'status', 'jam', 'kategori', 'total_jawaban'])
                ->filterColumn('tanggal', function ($query, $value) {
                    $query->whereHas('jadwal', function ($q) use ($value) {
                        $q->where('tanggal', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.guru.tugas.index', [
            'guru_id' => $this->dataUser->id,
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
    public function store(TugasRequest $request)
    {
        try {
            $dataId = $request->id;
            $validatedData = $request->validated();

            $data = Tugas::updateOrCreate(
                [
                    'id' => $dataId
                ],
                $validatedData
            );

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function submissions(Request $request, string $id)
    {
        $tugas = $this->tugas->where('id', $id)->first();
        if ($request->ajax()) {
            $data = Nilai::where('tugas_id', $tugas->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('siswa', function ($row) {
                    $row->siswa->nama ?? '-';
                })
                ->filterColumn('siswa', function ($query, $value) {
                    $query->whereHas('siswa', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.guru.tugas.index', [
            'guru_id' => $this->dataUser->id,
        ]);
    }

    public function show(string $id)
    {
        $data = $this->tugas->with('jadwal')->findOrFail($id);
        return view('pages.guru.tugas.show', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = Tugas::with('jadwal')->findOrFail($request->id);
        return response()->json([
            'success' => true,
            'data'    => $data,
            'jadwal'  => $data->jadwal
        ]);
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
    public function destroy(Request $request)
    {
        try {
            $data = Tugas::findOrFail($request->id);
            $data->delete();
            return Response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function send(Request $request)
    {
        $dataId = $request->id;
        try {
            $data = Tugas::findOrFail($dataId)->update([
                'is_draft' => false
            ]);
            return Response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dikirim!',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function import(Request $request)
    {
        try {
            // dd($request);
            $id = $request->tugas_id;
            $file = $request->file('file');
            Excel::import(new PertanyaanImport($id), $file);

            return Response()->json([
                'success' => true,
                'message' => 'Tugas berhasil diimport!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    // public function importEssay(Request $request)
    // {
    //     try {
    //         // dd($request);
    //         $id = $request->tugas_id;
    //         $file = $request->file('file');
    //         Excel::import(new PertanyaanEssayImport($id), $file);

    //         return Response()->json([
    //             'success' => true,
    //             'message' => 'Tugas berhasil diimport!'
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $th->getMessage(),
    //         ], 500);
    //     }
    // }

    public function template()
    {
        return public_path('template/_template_tugas_pilihan_ganda.xlsx');
    }
}
