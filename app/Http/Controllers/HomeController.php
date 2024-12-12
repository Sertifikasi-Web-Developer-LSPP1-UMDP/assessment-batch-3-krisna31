<?php

namespace App\Http\Controllers;

use App\Enum\StatusPendaftaran;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = $this->getUser();

        if (!$user->student_verified_at) {
            return view('message.index', [
                'color' => '#FFFDD0',
                'title' => 'Belum Terverifikasi',
                'message' => 'Anda <b>Belum Terverifikasi</b> Admin <br> Silahkan Cek Halaman Ini Secara Berkala'
            ]);
        }

        if (!$user->hasRole('mahasiswa') || $user->hasPermission('view-dashboard')) {
            return view('dashboard.index');
        }

        if ($user->hasRole('mahasiswa')) {
            if ($user->status_pendaftaran == StatusPendaftaran::BARU->value) {
                return view('student.index');
            }

            if ($user->status_pendaftaran == StatusPendaftaran::PENDING->value) {
                return view('message.index', [
                    'color' => '#FFFDD0',
                    'title' => 'Pending',
                    'message' => 'Pendaftaran Anda <b>Sudah Diterima</b> <br> Silahkan Cek Halaman Ini Secara Berkala'
                ]);
            }

            if ($user->status_pendaftaran == StatusPendaftaran::TOLAK->value) {
                return view('message.index', [
                    'color' => '#FF7276',
                    'title' => 'Ditolak',
                    'message' => 'Kami Mohon Maaf, <b>Pendaftaran Anda Ditolak</b> <br>Untuk Informasi Lebih Lanjut Silahkan Datang Ke Kampus.'
                ]);
            }

            if ($user->status_pendaftaran == StatusPendaftaran::LOLOS->value) {
                return view('message.index', [
                    'color' => '#A9FF80',
                    'title' => 'Diterima',
                    'message' => 'Selamat, <b>Pendaftaran Anda Diterima</b> <br>Silahkan Tunggu Informasi Lebih Lanjut Melalui Email yang Terdaftar'
                ]);
            }
        }

        return view('message.index', [
            'color' => '#FFFDD0',
            'title' => 'Tersesat?',
            'message' => 'Apakah Anda Tersesat?'
        ]);
    }
}
