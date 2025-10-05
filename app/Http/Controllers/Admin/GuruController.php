<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuruRequest;
use App\Models\Guru;
use App\Models\RefKelas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Guru::with('user')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_id', function ($row) {
                    return $row->user ? $row->user->username : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" data-id="' . $row->id . '" id="edit" data-bs-toggle="modal"
                    data-bs-target="#modalForm" class="me-2 edit btn btn-warning btn-sm" data-id="' . $row->id . '"><i class="bi bi-pencil"></i></button>';
                    $btn .= '<button type="button" data-id="' . $row->id . '" id="delete" class="me-2 btn btn-danger btn-sm" data-id="' . $row->id . '"><i class="bi bi-trash"></i></button>';
                    $btn .= '<button type="button" data-id="' . $row->user_id . '" id="updateAkun" data-bs-toggle="modal"
                    data-bs-target="#modalUpdateAkunForm" class="me-2 btn btn-secondary btn-sm" data-id="' . $row->id . '"><i class="bi bi-person-check"></i></button>';
                    $btn .= '<button type="button" data-id="' . $row->user_id . '" id="updatePassword" data-bs-toggle="modal"
                    data-bs-target="#modalUpdatePasswordForm" class="me-2 btn btn-primary btn-sm" data-id="' . $row->id . '"><i class="bi bi-key"></i></button>';
                    
                    return 
                    '<div class="d-flex align-items-center">'.
                    $btn .
                    '</div>';
                })
                ->rawColumns(['action'])
                ->filterColumn('user_id', function ($query, $value) {
                    $query->whereHas('user', function ($q) use ($value) {
                        $q->where('username', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.guru.index');
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
    public function store(GuruRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $data = Guru::create($validatedData);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Guru::with('mapel')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuruRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $data = Guru::findOrFail($id);
            $data->update($validatedData);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Guru::findOrFail($id);
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
}
