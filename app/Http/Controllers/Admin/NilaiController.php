<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = Siswa::with('nilai')->get();
        $tugas = Tugas::with('jadwal')->get();
        $nilai = Nilai::all();
        return view('pages.admin.nilai.index', compact('siswa', 'tugas', 'nilai'));
    }

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Siswa::with('user')->select('*');
    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('user_id', function ($row) {
    //                 return $row->user ? $row->user->username : '-';
    //             })
    //             ->addColumn('action', 'pages.admin.nilai._action')
    //             ->rawColumns(['action'])
    //             ->filterColumn('user_id', function ($query, $value) {
    //                 $query->whereHas('user', function ($q) use ($value) {
    //                     $q->where('username', 'LIKE', '%' . $value . '%');
    //                 });
    //             })
    //             ->make(true);
    //     }
    //     return view('pages.admin.nilai.index');
    // }

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
        $nilai = Nilai::where('siswa_id', $id)->get();
        return view('pages.admin.nilai.show', compact('nilai'));
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
