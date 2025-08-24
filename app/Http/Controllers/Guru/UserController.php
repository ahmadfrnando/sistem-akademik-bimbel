<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    public function editUsername()
    {
        $user = Auth::user();
        return view('pages.guru.user.edit-username', compact('user'));
    }

    public function editPassword()
    {
        $user = Auth::user();
        return view('pages.guru.user.edit-password', compact('user'));
    }

    public function updateUsername(Request $request)
    {   
        $id = Auth::user()->id;
        try {
            $validatedData = $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users'],
            ]);

            User::findOrFail($id)->update([
                'username' => $validatedData['username']
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updatePassword(ChangePasswordRequest $request)
    {   
        $id = Auth::user()->id;
        try {
            $validatedData = $request->validated();

            User::findOrFail($id)->update([
                'password' => bcrypt($validatedData['password'])
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diubah!',
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
        //
    }
}
