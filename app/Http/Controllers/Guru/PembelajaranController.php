<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\Pembelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PembelajaranController extends Controller
{
    protected $dataUser;
    protected $pembelajaran;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserGuru();
            return $next($request);
        });
        $this->pembelajaran = new Pembelajaran();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->pembelajaran->with('jadwal', 'guru')->select('*')->where('guru_id', $this->dataUser->id);
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
                ->addColumn('status', function ($row) {
                    $start = Carbon::parse(
                        $row->jadwal->tanggal . ' ' . $row->jadwal->jam_mulai
                    );

                    $end = Carbon::parse(
                        $row->jadwal->tanggal . ' ' . $row->jadwal->jam_selesai
                    );

                    $isActive = now()->between($start, $end);

                    return view('pages.guru.pembelajaran._status', compact('isActive'))->render();
                })
                ->addColumn('action', 'pages.guru.pembelajaran._action')
                ->rawColumns(['action', 'status', 'jam'])
                ->make(true);
        }
        return view('pages.guru.pembelajaran.index', [
            'guru_id' => $this->dataUser->id
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
        $dataId = $request->id;
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'judul' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:10240',
            'guru_id' => 'required|exists:guru,id',
            'keterangan' => 'nullable|string'
        ]);
        try {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/files/pembelajaran', $fileName);
                $filePath = 'files/pembelajaran/' . $fileName;
            } else {
                $filePath = $this->pembelajaran->where('id', $dataId)->first()->file ?? null;
            }
    
            $data = Pembelajaran::updateOrCreate(
                [
                    'id' => $dataId
                ],
                [
                    'guru_id' => $request->guru_id,
                    'jadwal_id' => $request->jadwal_id,
                    'judul' => $request->judul,
                    'keterangan' => $request->keterangan,
                    'file' => $filePath
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
    public function edit(Request $request)
    {
        $data  = Pembelajaran::findOrFail($request->id);
        $jadwal  = $data->jadwal;
        return response()->json([
            'success' => true,
            'data' => $data,
            'jadwal' => $jadwal
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
            $data = Pembelajaran::findOrFail($request->id);
            if ($data->file) {
                Storage::delete($data->file);
            }
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
