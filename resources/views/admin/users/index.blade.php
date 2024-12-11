@extends('adminlte::page')

@section('title', 'Pengguna dan Mahasiswa')

@section('content_header')
    {{-- <h1>Pengguna dan Mahasiswa</h1> --}}
@stop

@section('content')

    <div class="card">
        {{-- * Header --}}
        <div class="card-header">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <button type="button" class="btn btn-default btn-xs" onclick="refreshTable()">
                        <i class="fa fa-sync"></i> Refresh
                    </button>
                    {{-- * Create Button --}}
                    @permission('create-users')
                        <button type="button" class="btn btn-success btn-xs create-button">
                            <i class="fa fa-plus"></i> New User
                        </button>
                    @endpermission
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
                    <font style="font-size: 16px;" class="font-weight-bold">PENGGUNA & MAHASISWA</font>
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
    {{-- <div class="modal fade" id="formmodal" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-header-title">-</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @include('errors.validation')
                <form id="form">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_bank">Nama User</label>
                                    <input type="text" name="nama_bank" id="nama_bank" class="form-control"
                                        placeholder="Masukkan Nama User" required maxlength="255"
                                        oninput="return autoCapslock(this)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit-button">Tambah</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
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
                    if (data['deleted_at']) {
                        $(row).css('background-color', '#ffdbd3');
                    }
                },
                columns: [{
                        data: 'name',
                        title: 'name',
                    },
                    {
                        data: 'email',
                        title: 'email',
                    },
                    {
                        data: 'jenis_kelamin',
                        title: 'jenis_kelamin',
                    },
                    {
                        data: 'tempat_lahir',
                        title: 'tempat_lahir',
                    },
                    {
                        data: 'student_verified_at',
                        title: 'Diverifikasi Pada',
                        render: (data, type, row) => {
                            return data ? moment(data, 'YYYY-MM-DD h:m:s').format(
                                'DD-MM-YYYY h:m:s') : '';
                        }
                    },
                    {
                        data: 'student_verified_by',
                        title: 'Diverifikasi Oleh',
                    },
                    {
                        data: 'id',
                        title: 'Aksi',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full) {
                            return `
                                <button type="submit" class="btn btn-success btn-xs" onclick="verifikasiDaftarAkun('${full.id}', '${full.email}')">
                                    <i class="fa fa-check"></i>
                                </button>
                            `;
                        },
                    }
                ]
            });
        })

        function verifikasiDaftarAkun(userId, email) {
            // * Delete Button
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
                    $.post(`{{ route('users.index') }}/${userId}/verifikasiPembuatanAkun`, {
                            _method: 'PATCH',
                        })
                        .done(data => handleSuccessAjax(data, null, null, '#data-table'))
                        .fail(data => handleFailAjax(data));
                }
            })
        }
    </script>
@stop
