<?php

namespace App\Http\Controllers\Guru;

use App\Facades\Pengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\PertanyaanRequest;
use App\Models\OpsiPertanyaan;
use App\Models\Pertanyaan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
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

    public function index()
    {
        //
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
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'bobot'      => 'required|integer|min:1',
            'opsi'       => 'required|array|min:2',
            'opsi.*.label' => 'required|string',
            'opsi.*.text'  => 'required|string',
            'is_correct'   => 'required', // index opsi yang benar
        ], [
            'opsi.*.label.required' => 'Label opsi harus diisi.',
            'opsi.*.text.required'  => 'Teks opsi harus diisi.',
            'is_correct.required'   => 'opsi yang benar harus diisi.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan pertanyaan
            $pertanyaan = Pertanyaan::create([
                'tugas_id'   => $request->tugas_id ?? null, // opsional kalau ada tugas
                'pertanyaan' => $validated['pertanyaan'],
                'bobot'      => $validated['bobot'],
            ]);

            // Simpan opsi-opsi
            foreach ($validated['opsi'] as $index => $opsi) {
                OpsiPertanyaan::create([
                    'pertanyaan_id' => $pertanyaan->id,
                    'label'         => $opsi['label'],
                    'text'          => $opsi['text'],
                    'is_correct'    => ((string)$validated['is_correct'] === (string)$index),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah!'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeEssay(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'bobot'      => 'required|integer|min:1',
        ]);

        try {
            Pertanyaan::create([
                'tugas_id'   => $request->tugas_id ?? null, // opsional kalau ada tugas
                'pertanyaan' => $validated['pertanyaan'],
                'bobot'      => $validated['bobot'],
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah!'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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
    public function destroy(Request $request)
    {
        try {
            $data = Pertanyaan::findOrFail($request->id);
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
