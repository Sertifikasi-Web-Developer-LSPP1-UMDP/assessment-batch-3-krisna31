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
        if (!$this->getUser()->hasPermission('view-users')) throw new HttpException(403, "Anda Tidak Memiliki Akses Pada Resources Ini");

        $statuses = StatusPendaftaran::cases();

        return view('admin.users.index', compact('statuses'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }

    public function anydata(Request $request)
    {
        if (!$this->getUser()->hasPermission('manage-users')) throw new HttpException(403, "Anda Tidak Memiliki Akses Pada Resources Ini");

        $data = User::query();

        return DataTables::of($data)->make(true);
    }

    public function verifikasiPembuatanAkun(Request $request, $id)
    {
        if (!$this->getUser()->hasPermission('verifikasi-user')) throw new HttpException(403, "Anda Tidak Memiliki Akses Pada Resources Ini");

        DB::beginTransaction();
        try {
            if (!$id) throw new HttpException(400, 'ID Tidak Boleh Kosong');

            $user = User::find($id);

            if (!$user) throw new HttpException(400, 'Data User Tidak Ditemukan');

            $user->update([
                'student_verified_at' => now(),
                'student_verified_by' => auth()->user()->name,
            ]);

            DB::commit();
            return $this->helperService->message(true, 'Berhasil', 'User Berhasil Diverifikasi', null);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }

    public function getStatusHistories(Request $request, $id)
    {
        if (!$this->getUser()->hasPermission('update-status-user')) throw new HttpException(403, "Anda Tidak Memiliki Akses Pada Resources Ini");

        $data = StatusMahasiswaHistory::where('user_id', $id);

        return DataTables::of($data)->make(true);
    }

    public function storeStatusHistories(Request $request, $id)
    {
        if (!$this->getUser()->hasPermission('update-status-user')) throw new HttpException(403, "Anda Tidak Memiliki Akses Pada Resources Ini");

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
            return $this->helperService->message(true, 'Berhasil', 'User Berhasil Diubah Statusnya', null);
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
