<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
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

    public function anydata(Request $request)
    {
        $data = User::query();

        return DataTables::of($data)->make(true);
    }

    public function verifikasiPembuatanAkun(Request $request, $id)
    {
        if (!$id) throw new HttpException(400, 'ID Tidak Boleh Kosong');

        $user = User::find($id);

        if (!$user) throw new HttpException(400, 'Data User Tidak Ditemukan');

        $user->update([
            'student_verified_at' => now(),
            'student_verified_by' => auth()->user()->name,
        ]);

        return response()->json([
            'success' => true,
            'title' => 'Berhasil',
            'message' => 'User Berhasil Diverifikasi',
            'data' => null,
        ]);
    }
}
