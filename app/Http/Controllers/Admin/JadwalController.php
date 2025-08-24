<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalRequest;
use App\Models\Guru;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jadwal::with('guru')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('guru_id', function ($row) {
                    return $row->guru ? $row->guru->nama : '-';
                })
                ->editColumn('jam', function ($row) {
                    $jamMulai = \Carbon\Carbon::parse($row->jam_mulai)->format('H:i');
                    $jamSelesai = \Carbon\Carbon::parse($row->jam_selesai)->format('H:i');
                    return $jamMulai . ' - ' . $jamSelesai;
                })
                ->addColumn('action', 'pages.admin.jadwal._action')
                ->rawColumns(['action'])
                ->filterColumn('guru_id', function ($query, $value) {
                    $query->whereHas('guru', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.jadwal.index');
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
        try {
            $dataId = $request->id;
            $request->validate([
                'nama_jadwal' => 'required|string',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string',
                'guru_id' => 'required|exists:guru,id'
            ]);
    
            $data = Jadwal::updateOrCreate(
                [
                    'id' => $dataId
                ],
                [
                    'nama_jadwal' => $request->nama_jadwal,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan,
                    'guru_id' => $request->guru_id
                ]
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
            ]);
        }
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
    // public function edit(string $id)
    // {
    //     $data = Jadwal::with('guru')->findOrFail($id);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data
    //     ]);
    // }
    public function edit(Request $request)
    {   
        $data  = Jadwal::findOrFail($request->id);
        $guru  = $data->guru;
        return response()->json([
            'success' => true,
            'data' => $data,
            'guru' => $guru
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
            $data = Jadwal::where('id', $request->id)->delete();
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
