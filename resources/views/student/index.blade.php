@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

    <div class="card mt-3">
        {{-- * Header --}}
        <div class="card-header">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                </div>

                <div class="col-12 col-md-4 text-left text-center mb-2 mb-md-0 ">
                    <font style="font-size: 16px;" class="font-weight-bold">Form Pendaftaran Mahasiswa</font>
                </div>

                <div class="col-md-4 d-none mb-3 mb-md-0">
                </div>
            </div>
        </div>

        {{-- * Body --}}
        <div class="card-body">
            {{-- <div class="row">
                <div class="col">
                    <p>Selamat Datang {{ auth()->user()->email }}, Semoga Hari Anda Menyenangkan</p>
                </div>
            </div> --}}

            <div class="row">
                <div class="col">
                    <form autocomplete="off" id="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nama Mahasiswa:</label>
                                    <input required class="form-control" type="text" id="name" name="name"
                                        value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                                    <select required class="form-control select" id="jenis_kelamin" style="width: 100%"
                                        required name="jenis_kelamin" tabindex="-1" aria-hidden="true"
                                        data-placeholder="Pilih jenis_kelamin">
                                        <option value="laki_laki">Laki - Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir:</label>
                                    <input required class="form-control" type="text" id="tempat_lahir"
                                        name="tempat_lahir" placeholder="Isi Tempat Lahir">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                                        class="form-control timepicker" placeholder="Isi Tanggal Lahir"
                                        data-value="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                                        data-format="Y-m-d" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agama">Agama:</label>
                                    <select required class="form-control select" id="agama" style="width: 100%" required
                                        name="agama" tabindex="-1" aria-hidden="true" data-placeholder="Pilih Agama">
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katholik">Katholik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="buddha">Buddha</option>
                                        <option value="konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kewarganegaraan">Kewarganegaraan:</label>
                                    <input required class="form-control" type="text" id="kewarganegaraan"
                                        name="kewarganegaraan" placeholder="Isi Kewarganegaraan">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alamat">Alamat :</label>
                                    <textarea type="text" name="alamat" required class="form-control" id="alamat" required placeholder="Isi Alamat"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_hp">No HP/WA:</label>
                                    <input required class="form-control" type="text" id="no_hp" name="no_hp"
                                        placeholder="Isi No HP/WA">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_ibu_kandung">Nama Ibu Kandung:</label>
                                    <input required class="form-control" type="text" id="nama_ibu_kandung"
                                        name="nama_ibu_kandung" placeholder="Isi Nama Ibu Kandung">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jurusan_sekolah">Jurusan Sekolah:</label>
                                    <input required class="form-control" type="text" id="jurusan_sekolah"
                                        name="jurusan_sekolah" placeholder="Isi Jurusan Sekolah">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pilihan_progam_studi">Pilihan Program Studi:</label>
                                    <select required class="form-control select" id="pilihan_progam_studi"
                                        style="width: 100%" required name="pilihan_progam_studi" tabindex="-1"
                                        aria-hidden="true" data-placeholder="Pilih Program Studi">
                                        <option value="informatika">Informatika</option>
                                        <option value="sistem_informasi">Sistem Informasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="waktu_kuliah">Waktu Kuliah:</label>
                                    <select required class="form-control select" id="waktu_kuliah" style="width: 100%"
                                        required name="waktu_kuliah" tabindex="-1" aria-hidden="true"
                                        data-placeholder="Pilih Waktu Kuliah">
                                        <option value="pagi">Pagi</option>
                                        <option value="sore">Sore</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="asal_sekolah">Asal Sekolah:</label>
                                    <input required class="form-control" type="text" id="asal_sekolah"
                                        name="asal_sekolah" placeholder="Isi Asal Sekolah">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nisn">NISN:</label>
                                    <input required class="form-control" type="number" id="nisn" name="nisn"
                                        placeholder="Isi NISN">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alasan_memilih_kampus">Kenapa Memilih Kuliah Di Universitas Yoklah?</label>
                                    <input required class="form-control" type="text" id="alasan_memilih_kampus"
                                        name="alasan_memilih_kampus"
                                        placeholder="cth: Karena Universitas Yoklah Kampus Terkeren.">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success submit-button">Daftar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <p class="text-center">Status Pendaftaran Anda : {{ auth()->user()->status_pendaftaran }}</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(() => {
            $('#form').submit(e => {
                e.preventDefault();
                let formData = $('#form').serialize();
                formData += '&_method=PUT'

                loading();
                $.post('{{ route('users.index') }}/' + '{{ auth()->user()->id }}', formData)
                    .done(results => {
                        if (results.success) {
                            return Swal.fire({
                                title: results.title,
                                html: results.message,
                                icon: 'success',
                                confirmButtonText: "Okay!",
                                reverseButtons: true
                            }).then(result => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }

                        return Swal.fire({
                            title: results.title,
                            html: results.message,
                            icon: 'error',
                            confirmButtonText: "Ya",
                            reverseButtons: true
                        });
                    })
                    .fail(results => handleFailAjax(results));
            });
        });
    </script>
@stop
