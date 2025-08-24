<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Models\GuruKelas;
use App\Models\Materi;
use App\Models\RefKelas;
use App\Models\RefMapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KelolaPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataUser;
    protected $guruKelas;
    protected $materi;

    // Fungsi __construct untuk inisialisasi variabel
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->dataUser = Pengguna::getUserGuru();
            $this->guruKelas = GuruKelas::where('guru_id', $this->dataUser->id);
            $this->materi = Materi::where('guru_id', $this->dataUser->id);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->guruKelas->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    return $row->kelas->nama_kelas;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('guru.kelola-pembelajaran.show', $row->kelas_id) . '" class="me-2 edit btn btn-outline-primary btn-sm">Detail</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'kelas'])
                ->make(true);
        }
        return view('pages.guru.kelola-pembelajaran.index');
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
    public function store(MateriRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if ($request->hasFile('file_materi')) {
                $file = $request->file('file_materi');
                $path = $file->store('uploads', 'public');
                $validatedData['file_materi'] = $path;
                $data = Materi::create($validatedData);
            }
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $kelasId)
    {
        if ($request->ajax()) {
            $data = $this->materi->select('*')->where(['kelas_id' => $kelasId]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $color = $row->is_done ? 'success' : 'danger';
                    $text = $row->is_done ? 'Selesai' : 'Belum selesai';
                    $badge = '<span class="badge bg-'. $color .' bg-success">' . $text . '</span>';
                    return $badge;
                })
                ->addColumn('action', function ($row) use ($kelasId) {
                    $routeDetail = route('guru.kelola-pembelajaran.diskusi-materi', $row->id);
                    $btn = "
                    <div class='d-flex align-items-center'>
                        <button type='button' data-id='$row->id' id='edit' class='me-2 btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></button>
                        <button type='button' data-id='$row->id' id='delete' class='me-2 btn btn-danger btn-sm'><i class='bi bi-trash'></i></button>
                        <a href='$routeDetail' class='me-2 btn btn-outline-success btn-sm'>Diskusi</a>
                    </div>";
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $dataGuruKelas = $this->guruKelas->where(['kelas_id' => $kelasId])->first();
        return view('pages.guru.kelola-pembelajaran.show', compact('dataGuruKelas'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = $this->materi->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            if ($request->hasFile('file_materi')) {
                $materi = $this->materi->where('id', $id)->first();
                if ($materi && $materi->file_materi) {
                    Storage::disk('public')->delete($materi->file_materi);
                }
                $file = $request->file('file_materi');
                $path = $file->store('uploads', 'public');
                $validatedData['file_materi'] = $path;
            } else {
                unset($validatedData['file_materi']);
            }
            $data = Materi::findOrFail($id);
            $data->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah!',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Materi::findOrFail($id);
            if ($data->file_materi) {
                Storage::disk('public')->delete($data->file_materi);
            }
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function diskusi(Request $request, string $id)
    {
        $dataMateri = $this->materi->findOrFail($id);
        $tanggapans = $dataMateri->tanggapanMateri()->with('siswa')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.guru.kelola-pembelajaran.diskusi-materi.index', compact('dataMateri', 'tanggapans'));
    }
}
