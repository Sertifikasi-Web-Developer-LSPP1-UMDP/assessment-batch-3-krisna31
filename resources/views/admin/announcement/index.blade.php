@extends('adminlte::page')

@section('title', 'Pengguna dan Mahasiswa')

@section('content_header')
    {{-- <h1>Pengguna dan Mahasiswa</h1> --}}
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
                    {{-- @permission('create-users') --}}
                    <button type="button" class="btn btn-success btn-xs create-button">
                        <i class="fa fa-plus"></i> Buat Pengumuman
                    </button>
                    {{-- @endpermission --}}
                </div>

                <div class="col-12 col-md-4 text-left text-center mb-2 mb-md-0 ">
                    {{-- * Dropdown Menu --}}
                    <span class="btn-group" id="action-menu" style="display: none">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"
                            style="padding: 0 30px">
                            Action
                        </button>
                    </span>
                    <font style="font-size: 16px;" class="font-weight-bold">PENGUMUMAN</font>
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
        <x-slot name="id_modal">create-modal</x-slot>
        <x-slot name="is_form">false</x-slot>
        <x-slot name="modal_size">xl</x-slot>

        <x-slot name="slot">
            <form autocomplete="off" id="form">
                <div class="row">
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="urutan">Urutan :</label>
                            <input type="number" name="urutan" class="form-control" id="urutan">
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="title">Judul :</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="path">Gambar :</label>
                            <div class="custom-file">
                                <input type="file" name="path" class="custom-file-input" id="path"
                                    accept="image/png, image/gif, image/jpeg" required>
                                <label class="custom-file-label" id="path_label" for="path">Pilih Gambar</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 status_input">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control select" id="status" style="width: 100%" required="required"
                                name="status" tabindex="-1" aria-hidden="true" data-placeholder="Pilih Status">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}">
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="description">Deskripsi :</label>
                            <textarea type="text" name="description" class="form-control" id="description" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success submit-button">Tambah Data</button>
                    </div>
                </div>
            </form>
        </x-slot>
    </x-modal>
@stop

@section('css')
@stop

@section('js')
    <script>
        var table, id;

        function refreshTable() {
            $('#action-menu').hide();
            $('#data-table').DataTable().ajax.reload();
        }

        $(() => {
            // ! Initialize Data Table
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                // scrollY: '80vh',
                searchDelay: 1000,
                ajax: '{{ route('announcements.anydata') }}',
                fnRowCallback: (row, data, iDisplayIndex, iDisplayIndexFull) => {
                    if (data['status'] == 'NONAKTIF') {
                        $(row).css('background-color', '#ffdbd3');
                    }
                },
                columns: [{
                        data: 'path',
                        title: 'Gambar',
                        render: (data, type, row) => {
                            return data ?
                                `<img src="{{ asset('${data}') }}" class="rounded mx-auto d-block" alt="${data}" width="100" height="100">` :
                                '404 Not Found';
                        }
                    },
                    {
                        data: 'title',
                        title: 'Judul',
                    },
                    {
                        data: 'description',
                        title: 'Deskripsi',
                    },
                    {
                        data: 'status',
                        title: 'Status',
                    },
                    {
                        data: 'created_at',
                        title: 'Dibuat Pada',
                        render: (data, type, row) => {
                            return data ? moment(data, 'YYYY-MM-DD hh:mm:ss').format(
                                'DD-MM-YYYY hh:mm:ss') : '';
                        }
                    },
                    {
                        data: 'created_by',
                        title: 'Dibuat Oleh',
                    },
                    {
                        data: 'id',
                        title: 'Aksi',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, full) {
                            return `
                                <button type="submit" class="btn btn-info btn-xs" onclick="editAnnouncement('${full.id}', '${full.title}', '${full.description}', '${full.status}')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="submit" class="btn btn-danger btn-xs" onclick="deleteAnnouncement('${full.id}', '${full.title}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            `;
                        },
                    }
                ]
            });
        })

        // * Create Button
        $('.create-button').click(() => {
            $('#create-modal').modal('show');
            $('#modal-header-title').text('Create Data');
            $('.status_input').hide();
            $('#path').prop('required', true);

            // ! Dont Reset if before is add class
            if (!$('#create-modal form').hasClass('add')) {
                $('#form')[0].reset();
                $('#form select').change();
            }
            $('#form').removeClass('edit').addClass('add');
            $('.submit-button').text('Create').prop('disabled', false);
        });

        // * Create and Update submit
        $('#form').submit(function(e) {
            e.preventDefault();
            loading();
            $('.submit-button').attr('disabled', true);

            var formData = new FormData(this); // ! Create new FormData
            let url = '{{ route('announcements.index') }}';

            if ($(this).hasClass('edit')) {
                url += '/' + id;
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    handleSuccessAjax(response, '#create-modal', '#form');
                    $('#form input[type="file"]').val('').change();
                },
                error: function(response) {
                    handleFailAjax(response);
                },
                complete: function() {
                    $('.submit-button').prop('disabled', false);
                }
            });
        });

        $('input[type="file"][name="path"]').change(function(e) {
            let fileNames = [];
            for (let i = 0; i < e.target.files.length; i++) {
                fileNames.push(e.target.files[i].name);
            }

            let displayText = fileNames.join(', ');
            if (fileNames.length > 1) {
                displayText = fileNames.length + " gambar selected";
            } else if (fileNames.length === 0) {
                displayText = 'Pilih Gambar';
            }
            $('#path_label').html(displayText);
        });

        function editAnnouncement(annId, title, description, status) {
            // $('#urutan').val(urutan);
            $('#path').prop('required', false);
            $('#title').val(title);
            $('#description').val(description);
            $('#status').val(status).change();

            id = annId;

            $('#create-modal')
                .find('#modal-header-title').html(`Edit Data`).end()
                .find('form').attr('data-id', annId).end()
                .modal('show');

            $('.status_input').show();
            $('#form').removeClass('add').addClass('edit');
            $('.submit-button').text('Ubah').prop('disabled', false);
        }

        function deleteAnnouncement(annId, title) {
            Swal.fire({
                title: 'Hapus?',
                text: `Apakah ingin menghapus pengumuman dengan judul ${title}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus Pengumuman!",
                cancelButtonText: "Batal!",
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post(`{{ route('announcements.index') }}/${annId}`, {
                            _method: 'DELETE',
                        })
                        .done(data => handleSuccessAjax(data, null, null, '#data-table'))
                        .fail(data => handleFailAjax(data));
                }
            })
        }
    </script>
@stop
