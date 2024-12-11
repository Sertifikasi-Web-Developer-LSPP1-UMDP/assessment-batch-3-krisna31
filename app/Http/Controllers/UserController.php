<?php

namespace App\Http\Controllers;

use App\Enum\StatusPendaftaran;
use App\Models\StatusMahasiswaHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = StatusPendaftaran::cases();

        return view('admin.users.index', compact('statuses'));
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

    public function getStatusHistories(Request $request, $id)
    {
        $data = StatusMahasiswaHistory::where('user_id', $id);

        return DataTables::of($data)->make(true);
    }

    public function
    storeStatusHistories(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (!$id) throw new HttpException(400, 'ID Tidak Boleh Kosong');

            $user = User::find($id);

            if (!$user) throw new HttpException(400, 'Data User Tidak Ditemukan');

            $statuses = array_map(fn($status) => $status->value, StatusPendaftaran::cases());

            $request->validate([
                'status' => ['required', 'string', 'max:255', Rule::in($statuses)],
            ]);

            $savedData = StatusMahasiswaHistory::create([
                'user_id' => $id,
                'status' => $request->status,
            ]);

            $user->update([
                'status_pendaftaran' => $request->status,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'User Berhasil Diverifikasi',
                'data' => null,
            ]);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }
}
