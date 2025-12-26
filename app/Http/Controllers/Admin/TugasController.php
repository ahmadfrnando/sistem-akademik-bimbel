<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\TugasRequest;
use App\Imports\PertanyaanEssayImport;
use App\Imports\PertanyaanImport;
use App\Models\Nilai;
use App\Models\RefKategoriTugas;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tugas::orderBy('created_at', 'desc')->select('*');
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
                    return $row->nilai->count() ?? 0;
                })
                ->addColumn('status', function ($row) {
                    $dateTime = $row->jadwal->tanggal . ' ' . $row->jadwal->jam_selesai;
                    return view('pages.admin.tugas._status')->with('row', $dateTime)->render();
                })
                ->addColumn('action', 'pages.admin.tugas._action')
                ->rawColumns(['action', 'status', 'jam', 'kategori', 'total_jawaban'])
                ->filterColumn('tanggal', function ($query, $value) {
                    $query->whereHas('jadwal', function ($q) use ($value) {
                        $q->where('tanggal', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.tugas.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function submissions(Request $request, string $id)
    {
        $tugas = Tugas::where('id', $id)->first();
        if ($request->ajax()) {
            $data = Nilai::where('tugas_id', $tugas->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('siswa', function ($row) {
                    return $row->siswa->nama ?? '-';
                })
               ->addColumn('action', function ($row) {
                    $url = route('admin.tugas.submissions.show', [
                        'tugas' => $row->tugas_id,
                        'siswa' => $row->siswa_id,
                    ]);

                    return '
                        <button
                            type="button"
                            onclick="window.location.href=\'' . $url . '\'"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Lihat
                        </button>
                    ';
                })
                ->rawColumns(['siswa', 'action'])
                ->filterColumn('siswa', function ($query, $value) {
                    $query->whereHas('siswa', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.tugas.index');
    }
    
    public function submissionsShow(Tugas $tugas, Siswa $siswa)
    {   
        $pertanyaan = $tugas->pertanyaan()->with(['opsi', 'jawaban_pilihan_ganda_siswa' => function($query) use ($siswa) {
            $query->where('siswa_id', $siswa->id);
        }])->get();
        $nilaiSiswa = Nilai::where('tugas_id', $tugas->id)->where('siswa_id', $siswa->id)->first();
        return view('pages.admin.tugas.submission-show', [
            'tugas' => $tugas,
            'siswa' => $siswa,
            'pertanyaan' => $pertanyaan,
            'nilaiSiswa' => $nilaiSiswa,
        ]);
    }

    public function show(string $id)
    {
        $data = Tugas::with('jadwal')->findOrFail($id);
        return view('pages.admin.tugas.show', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
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
}
