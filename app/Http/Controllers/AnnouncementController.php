<?php

namespace App\Http\Controllers;

use App\Enum\StatusGlobal;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = StatusGlobal::cases();

        return view('admin.announcement.index', compact('statuses'));
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
        $validatedRequest = $request->validate([
            'urutan' => 'required|integer|unique:\App\Models\Announcement,urutan',
            'path' => 'required|file|image|max:10240|mimes:jpg,jpeg,png',
        ]);

        DB::beginTransaction();
        try {
            $savedData = Announcement::create($validatedRequest);

            if ($request->hasFile('path')) {
                $fileName = $this->helperService->saveImage($request->file('path'), 'PENGUMUMAN');
                $savedData->update([
                    'path' => $fileName,
                ]);
            }

            DB::commit();
            return $this->helperService->message(true, 'Berhasil', 'Pengumuman Berhasil Ditambahkan', null);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        if (!$announcement->id) throw new HttpException(400, 'Data Tidak Ditemukan');

        $statuses = array_map(fn($status) => $status->value, StatusGlobal::cases());

        $validatedRequest = $request->validate([
            'urutan' => 'required|integer|unique:\App\Models\Announcement,urutan,' . $announcement->id,
            'path' => 'sometimes|file|image|max:10240|mimes:jpg,jpeg,png',
            'status' => ['required', 'string', 'max:255', Rule::in($statuses)]
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('path')) $this->helperService->deleteImage($announcement->path);

            $savedData = $announcement->update($validatedRequest);

            if ($request->hasFile('path')) {
                $fileName = $this->helperService->saveImage($request->file('path'), 'PENGUMUMAN');
                $announcement->update([
                    'path' => $fileName,
                ]);
            }

            DB::commit();
            return $this->helperService->message(true, 'Berhasil', 'Pengumuman Berhasil Ditambahkan', $savedData);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        if (!$announcement->id) throw new HttpException(400, 'Data Tidak Ditemukan');

        DB::beginTransaction();
        try {
            $this->helperService->deleteImage($announcement->path);

            $announcement->delete();

            DB::commit();
            return $this->helperService->message(true, 'Berhasil', 'Pengumuman Berhasil Ditambahkan', null);
        } catch (HttpException $e) {
            DB::rollBack();
            throw new HttpException($e->getStatusCode(), $e->getMessage());
        } catch (\Throwable $e) {
            Log::critical($this->getUser()->username . json_encode($request->all()) . " - $e");
            DB::rollBack();
            throw new HttpException(500, 'Ada kesalahan di sisi server, silahkan coba lagi, jika berulang laporkan masalah ini ke administrator');
        }
    }

    public function anydata(Request $request)
    {
        $data = Announcement::query();

        return DataTables::of($data)->make(true);
    }
}
