<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pembelajaran::with('jadwal', 'guru')->select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('guru_id', function ($row) {
                    return $row->guru ? $row->guru->nama : '-';
                })
                ->addColumn('file', function ($row) {
                    return '<a href="javascript:void(0)" onClick="showFunc(\''.$row->file.'\')" class="btn btn-lihat btn-primary btn-sm"><i class="bi bi-file-earmark-check me-1"></i>Lihat</a>';
                })
                ->editColumn('jam', function ($row) {
                    $jamMulai = \Carbon\Carbon::parse($row->jadwal->jam_mulai)->format('H:i');
                    $jamSelesai = \Carbon\Carbon::parse($row->jadwal->jam_selesai)->format('H:i');
                    return $jamMulai . ' - ' . $jamSelesai;
                })
                ->rawColumns(['action', 'file'])
                ->filterColumn('guru_id', function ($query, $value) {
                    $query->whereHas('guru', function ($q) use ($value) {
                        $q->where('nama', 'LIKE', '%' . $value . '%');
                    });
                })
                ->make(true);
        }
        return view('pages.admin.pembelajaran.index');
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
