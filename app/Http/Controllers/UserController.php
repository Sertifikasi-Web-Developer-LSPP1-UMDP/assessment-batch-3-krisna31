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
    public function update(Request $request, User $user)
    {
        if (!$user->id) throw new HttpException(400, 'Data Tidak Ditemukan');

        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255|in:laki_laki,perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|string|max:255|date',
            'agama' => 'required|string|max:255|in:islam,kristen,katholik,hindu,buddha,konghucu',
            'kewarganegaraan' => 'required|string|max:255',
            'alamat' => 'required|string|max:65535',
            'no_hp' => 'required|string|max:255',
            'nama_ibu_kandung' => 'required|string|max:255',
            'jurusan_sekolah' => 'required|string|max:255',
            'pilihan_progam_studi' => 'required|string|max:255|in:informatika,sistem_informasi',
            'waktu_kuliah' => 'required|string|max:255|in:pagi,sore',
            'asal_sekolah' => 'required|string|max:255',
            'nisn' => 'required|string|max:255',
            'alasan_memilih_kampus' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $validatedRequest['status_pendaftaran'] = StatusPendaftaran::PENDING;
            $savedData = $user->update($validatedRequest);

            StatusMahasiswaHistory::create([
                'user_id' => $user->id,
                'status' => StatusPendaftaran::PENDING,
            ]);

            DB::commit();

            return $this->helperService->message(true, 'Berhasil', 'Pendaftaran Mahasiswa Berhasil Dilakukan', $savedData);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }

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

        try {
            $data = User::whereHas('roles', function ($q) {
                $q->where('name', 'mahasiswa');
            });

            return DataTables::of($data)->make(true);
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
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

        try {
            $data = StatusMahasiswaHistory::where('user_id', $id);

            return DataTables::of($data)->make(true);
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
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
