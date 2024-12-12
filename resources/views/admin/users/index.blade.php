@extends('adminlte::page')

@section('title', 'Mahasiswa')

@section('content_header')
    {{-- <h1>Mahasiswa</h1> --}}
@stop

@section('content')
    <div class="card mt-3">
        {{-- * Header --}}
        <div class="card-header">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <button type="button" class="btn btn-default btn-xs" onclick="refreshTable()">
                        <i class="fa fa-sync"></i> Refresh
                    </button>
                    {{-- * Create Button --}}
                    {{-- @permission('create-users')
                        <button type="button" class="btn btn-success btn-xs create-button">
                            <i class="fa fa-plus"></i> New User
                        </button>
                    @endpermission --}}
                </div>

                <div class="col-12 col-md-4 text-left text-center mb-2 mb-md-0 ">
                    {{-- * Dropdown Menu --}}
                    <span class="btn-group" id="action-menu" style="display: none">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"
                            style="padding: 0 30px">
                            Action
                        </button>

                        {{-- * List Action --}}
                        <ul class="dropdown-menu">
                            {{-- @permission('view-users')
                                            <li class="view-button dropdown-item"><a href="#" style="color: #367fa9"><i class="fa fa-eye"></i> View</a></li>
                                        @endpermission --}}

                            {{-- @permission('update-users') --}}
                            <li class="update-button dropdown-item">
                                <a href="#" style="color: #4809a0"><i class="fa fa-edit"></i> Edit</a>
                            </li>
                            {{-- @endpermission --}}

                            {{-- @permission('add-users')
                                            <li class="add-button dropdown-item"><a href="#" style="color: #06baca"><i class="fa fa-file-text-o"></i> Add Detail</a></li>
                                        @endpermission --}}

                            {{-- @permission('post-users') --}}
                            {{-- <li class="post-button dropdown-item"><a href="#" style="color: #008d4c"><i
                                            class="fa fa-bullhorn"></i> Post</a></li> --}}
                            {{-- @endpermission --}}

                            {{-- @permission('unpost-users') --}}
                            {{-- <li class="unpost-button dropdown-item"><a href="#" style="color: #e08e0b"><i
                                            class="fa fa-undo"></i> Unpost</a></li> --}}
                            {{-- @endpermission --}}

                            {{-- @permission('print-users') --}}
                            {{-- <li class="print-button dropdown-item"><a
                                        href="{{ route('users.printpdf', ['id' => 'no_premi']) }}"
                                        id="print" style="color: #d73925"><i class="fa fa-print"></i> Print</a>
                                </li> --}}
                            {{-- @endpermission --}}

                            {{-- @permission('delete-users') --}}
                            <li class="delete-button dropdown-item"><a href="#" style="color: #f44336"><i
                                        class="fa fa-trash"></i> Delete</a></li>
                            {{-- @endpermission --}}
                        </ul>
                    </span>
                    <font style="font-size: 16px;" class="font-weight-bold">MAHASISWA</font>
                </div>

                <div class="col-md-4 d-none mb-3 mb-md-0">
                </div>
            </div>
        </div>

        {{-- * Body --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="data-table" style="font-size: 12px; width: 100%">
                    <thead class="bg-lightblue">
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- * Form Modal --}}
    <x-modal>
        <x-slot name="id_modal">status-modal</x-slot>
        <x-slot name="is_form">false</x-slot>
        <x-slot name="modal_size">xl</x-slot>

        <x-slot name="slot">
            <form autocomplete="off" id="status-mahasiswa-form">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Nama Mahasiswa:</label>
                            <input class="form-control" type="text" id="name" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control select" id="status" style="width: 100%" required name="status"
                                tabindex="-1" aria-hidden="true" data-placeholder="Pilih Status">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}">
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success submit-button">Ubah Data Status</button>
                    </div>
                </div>
            </form>

            <div class="row mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="status-mahasiswa-histories-table"
                        style="width: 100%; font-size: 12px;"></table>
                </div>
            </div>
        </x-slot>
    </x-modal>
@stop

@section('css')
@stop

@section('js')
    <script>
        function refreshTable() {
            $('#action-menu').hide();
            $('#data-table').DataTable().ajax.reload();
        }

        $(() => {
            // ! Initialize Data Table
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                // scrollY: '80vh',
                searchDelay: 1000,
                ajax: '{{ route('users.anydata') }}',
                fnRowCallback: (row, data, iDisplayIndex, iDisplayIndexFull) => {
                    if (data['deleted_at'] || data['status_pendaftaran'] == 'TOLAK') {
                        $(row).css('background-color', '#ffdbd3');
                    } else if (!data['student_verified_at']) {
                        $(row).css('background-color', '#ffe896');
                    } else if (data['student_verified_at'] && data['status_pendaftaran'] == 'BARU') {
                        $(row).css('background-color', '#FDF0BE');
                    } else if (data['status_pendaftaran'] == 'PENDING') {
                        $(row).css('background-color', '#B3F6F9');
                    } else if (data['status_pendaftaran'] == 'LOLOS') {
                        $(row).css('background-color', '#a1ffa4');
                    }
                },
                order: [
                    [3, 'desc']
                ],
                columns: [{
                        data: 'name',
                        title: 'name',
                    },
                    {
                        data: 'email',
                        title: 'email',
                    },
                    {
                        data: 'status_pendaftaran',
                        title: 'status_pendaftaran',
                    },
                    {
                        data: 'student_verified_at',
                        title: 'Diverifikasi Pada',
                        render: (data, type, row) => {
                            return data ? moment(data, 'YYYY-MM-DD hh:mm:ss').format(
                                'DD-MM-YYYY hh:mm:ss') : '';
                        }
                    },
                    {
                        data: 'student_verified_by',
                        title: 'Diverifikasi Oleh',
                    },
                    {
                        data: 'jenis_kelamin',
                        title: 'Jenis Kelamin',
                    },
                    {
                        data: 'tempat_lahir',
                        title: 'Tempat Lahir',
                    },
                    {
                        data: 'tanggal_lahir',
                        title: 'Tanggal Lahir',
                    },
                    {
                        data: 'agama',
                        title: 'Agama',
                    },
                    {
                        data: 'kewarganegaraan',
                        title: 'Kewarganegaraan',
                    },
                    {
                        data: 'alamat',
                        title: 'Alamat',
                    },
                    {
                        data: 'no_hp',
                        title: 'No HP/WA',
                    },
                    {
                        data: 'nama_ibu_kandung',
                        title: 'Nama Ibu Kandung',
                    },
                    {
                        data: 'jurusan_sekolah',
                        title: 'Jurusan Sekolah',
                    },
                    {
                        data: 'pilihan_progam_studi',
                        title: 'Pilihan Progam Studi',
                    },
                    {
                        data: 'waktu_kuliah',
                        title: 'Waktu Kuliah',
                    },
                    {
                        data: 'asal_sekolah',
                        title: 'Asal Sekolah',
                    },
                    {
                        data: 'nisn',
                        title: 'NISN',
                    },
                    {
                        data: 'alasan_memilih_kampus',
                        title: 'Alasan Memilih Kampus',
                    },
                    {
                        data: 'id',
                        title: 'Aksi',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full) {
                            let button = ``;

                            @permission('verifikasi-user')
                                if (!full.student_verified_at) {
                                    button += `
                                        <button type="submit" class="btn btn-success btn-xs" onclick="verifikasiDaftarAkun('${full.id}', '${full.email}')">
                                            <i class="fa fa-check"></i>
                                            </button>
                                            `;
                                }
                            @endpermission

                            @permission('update-status-user')
                                button += `
                                    <button type="submit" class="btn btn-info btn-xs" onclick="updateStatusMahasiswa('${full.id}', '${full.name}')">
                                        <i class="fa fa-edit"></i>
                                        </button>
                                        `;
                            @endpermission

                            if (full.status_pendaftaran == 'LOLOS' && !(full.permissions.some(
                                    permission =>
                                    permission.name && permission.name.includes(
                                        'view-dashboard')
                                ))) {
                                button += `
                                    <button type="submit" class="btn btn-primary btn-xs" onclick="diizinkanAksesDashboard('${full.id}', '${full.email}')">
                                        <i class="fa fa-check-double"></i>
                                        </button>
                                        `;
                            }

                            return `<div style="white-space: nowrap;">${button}</div>`;
                        },
                    }
                ]
            });
        })

        function verifikasiDaftarAkun(userId, email) {
            Swal.fire({
                title: 'Verifikasi?',
                text: `Apakah user dengan email ${email} yang ingin di verifikasi sudah benar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya, Verifikasi Pendaftaran!",
                cancelButtonText: "Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    loading();
                    $.post(`{{ route('users.index') }}/${userId}/verifikasiPembuatanAkun`, {
                            _method: 'PATCH',
                        })
                        .done(data => handleSuccessAjax(data, null, null, '#data-table'))
                        .fail(data => handleFailAjax(data));
                }
            })
        }

        function diizinkanAksesDashboard(userId, email) {
            Swal.fire({
                title: 'Izinkan Akses Dashboard?',
                text: `Apakah user dengan email ${email} yang ingin di izinkan sudah benar?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya, Izinkan Melihat Dashboard!",
                cancelButtonText: "Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    loading();
                    $.post(`{{ route('users.index') }}/${userId}/izinkanAksesDashboard`, {
                            _method: 'PATCH',
                        })
                        .done(data => handleSuccessAjax(data, null, null, '#data-table'))
                        .fail(data => handleFailAjax(data));
                }
            })
        }

        function updateStatusMahasiswa(userId, name) {
            let data = $('#data-table').DataTable().row('.selected').data();

            $('#status-mahasiswa-histories-table').DataTable({
                destroy: true,
                serverSide: true,
                info: false,
                scrollCollapse: true,
                ajax: `{{ route('users.index') }}/${userId}/status`,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'status',
                        title: 'Status',
                        render: (data, type, row) => {
                            let badgeClass = 'badge-success';

                            switch (data) {
                                case 'TOLAK':
                                    badgeClass = 'badge-danger';
                                    break;
                                case 'BARU':
                                    badgeClass = 'badge-warning';
                                    break;
                                case 'PENDING':
                                    badgeClass = 'badge-info    ';
                                    break;
                            }

                            return `<span class="badge ${badgeClass}" style="font-size: .8rem;">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_at',
                        title: 'Dibuat Pada',
                        render: (data, type, row) => {
                            return data ? moment(data, 'YYYY-MM-DD hh:mm:ss').format(
                                'DD-MM-YYYY hh:mm:ss') : '';
                        }
                    },
                ],
                preDrawCallback: function() {
                    $(this.api().table().header()).addClass('bg-info');
                },
                drawCallback: settings => {
                    adjustDataTableColumnWidth();
                    $('.dt-scroll-body').css('min-height', '40vh');
                }
            })

            $('#status-modal')
                .find('#modal-header-title').html(`Status History <b>${name}</b>`).end()
                .find('form').attr('data-id', userId).end()
                .modal('show');

            $('#name').val(name);

            $('#status-mahasiswa-form').off('submit').on('submit', function(e) {
                e.preventDefault();
                loading();

                let formData = $(this).serialize();
                let url = `{{ route('users.index') }}/${userId}/status`;

                $.post(url, formData)
                    .done(data => {
                        handleSuccessAjax(data, null, null,
                            '#status-mahasiswa-histories-table');
                        refreshTable();
                    })
                    .fail(data => handleFailAjax(data));
            });
        }
    </script>
@stop
