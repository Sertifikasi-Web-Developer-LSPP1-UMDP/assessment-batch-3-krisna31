<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('jenis_kelamin', 25)->nullable();
            $table->string('tempat_lahir', 150)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('jurusan_sekolah')->nullable();
            $table->string('pilihan_progam_studi')->nullable();
            $table->string('waktu_kuliah')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('nisn')->nullable();
            $table->string('alasan_memilih_kampus')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('student_verified_by')->nullable();
            $table->timestamp('student_verified_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
