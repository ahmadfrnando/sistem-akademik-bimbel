<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JawabanPilihanGandaSiswa;
use App\Models\OpsiPertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JawabanPilihanGandaSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            'siswa_id' => 'required|integer',
            'jawaban'  => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['jawaban'] as $pertanyaanId => $opsiId) {
                $opsi = OpsiPertanyaan::findOrFail($opsiId);

                JawabanPilihanGandaSiswa::create([
                    'pertanyaan_id'     => $pertanyaanId,
                    'opsi_pertanyaan_id' => $opsiId,
                    'siswa_id'          => $validated['siswa_id'],
                    'is_correct'        => $opsi->is_correct,
                    'nilai'             => $opsi->is_correct ? $opsi->pertanyaan->bobot : 0,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jawaban berhasil disimpan!'
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
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
    public function destroy(string $id)
    {
        //
    }
}
