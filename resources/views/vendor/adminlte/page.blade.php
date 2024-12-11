@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    <style>
        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 10px
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            height: auto;
            margin-top: -3px
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0 !important;
            padding: 6px 12px;
            height: 40px !important
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 26px;
            position: absolute;
            top: 5px !important;
            right: 10px;
            width: 20px
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 6px !important;
            right: 1px;
            width: 20px
        }

        .select2-selection__choice {
            color: black !important;
        }
    </style>
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    <script>
        // $.fn.dataTable.defaults.fnHeaderCallback = () => OverlayScrollbars(document.querySelectorAll('.dt-scroll-body'), {});
        // * Set the default locale for moment.js
        moment.locale('id');

        // Select2
        $('.select:not(#formmodal .select)').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: $(this).data('allow-clear') ?? true,
            closeOnSelect: $(this).data('close-on-select') ?? true,
            width: '100%',
        });

        $('#formmodal .select').select2({
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: $(this).data('allow-clear') ?? true,
            closeOnSelect: $(this).data('close-on-select') ?? true,
            width: '100%',
            dropdownParent: $('#formmodal')
        });

        // * Attach error handling to all existing and future DataTables
        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            let html;
            let icon = 'error';
            if (settings.jqXHR.status == 500) {
                html = `
                    Terjadi kesalahan saat memuat data. <br>
                    Silahkan coba <b>Refresh Halaman</b> <br>
                    Jika berulang silahkan screenshot halaman ini dan laporkan ke administrator.
                    <br>
                    <br>
                    <span style="font-size: 1.2rem; font-style: italic; color: red;">
                        <b>Detail Error:</b>
                        <br>
                        ${settings.jqXHR.responseJSON == undefined ?
                                settings.jqXHR.statusText :
                                settings.jqXHR.responseJSON.message}
                        <br>
                    </span>
                    <span style="font-size: .83rem; font-weight: bold;">Route: ${settings.ajax}</span>
                `
            } else if (settings.jqXHR.status.toString().includes(2)) {
                icon = 'warning';
                html = `
                    Tidak terjadi error pada server, namun terdapat warning. <br>
                    <br>
                    <br>
                    <span style="font-size: 1.2rem; font-style: italic; color: #888c06;">
                        <b>Detail Warning:</b>
                        <br>
                        ${message}
                        <br>
                    </span>
                    <span style="font-size: .83rem; font-weight: bold;">Route: ${settings.ajax}</span>
                `
            } else if (settings.jqXHR.status == 403) {
                icon = 'warning';
                html =
                    `<span style="font-size: 1rem; font-weight: bold;">${settings.jqXHR.responseJSON.message}</span>`;
                syncUserLoginAndCompanyStatus();
            } else {
                html = `
                    <span style="font-size: 1.2rem; font-style: italic; color: red;">
                        <b>Detail Error:</b>
                        <br>
                        ${settings.jqXHR.responseJSON.message}
                        <br>
                        <br>
                        Jika anda merasa ini adalah kesalahan silahkan screenshot halaman ini dan laporkan ke administrator.
                    </span>
                    <span style="font-size: .83rem; font-weight: bold;">Route: ${settings.ajax}</span>
                `
            }

            Swal.fire({
                title: icon.toUpperCase(),
                html: html,
                icon,
                confirmButtonText: 'OK',
                allowOutsideClick: false
            });
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        function handleFailAjax(results) {
            if (results.status === 422) {
                let errors = results.responseJSON.errors;

                let errorMessage = Object.values(errors)
                    .map(error => `<span class="text-danger font-weight-bold font-italic">${error}</span>`)
                    .join('<br />');

                return Swal.fire("Gagal!", errorMessage, "error");
            } else {
                return Swal.fire("Gagal!", results.responseJSON.message, "error");
            }
        }

        function handleSuccessAjax(results, id_modal = null, id_form = null, id_table = null) {
            if (id_modal != null) {
                $(id_modal).modal('hide');
            }
            if (id_form != null) {
                $(id_form).removeClass('edit add')
                $(id_form)[0].reset();
                $(`${id_form} select`).val(null).change();
            }
            if (id_table == null) {
                refreshTable();
            } else {
                $(id_table).DataTable().ajax.reload();
            }
            return Swal.fire(results.title, results.message, 'success');
        }

        function adjustDataTableColumnWidth() {
            // * Adjust column width after editing
            setTimeout(() => {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            }, 0);
        }

        // Notificaion
        function loading() {
            return Swal.fire({
                title: "<b>Proses Sedang Berlangsung</b>",
                icon: "warning",
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
        }

        $(document).ready(() => {
            @if (Session::has('error'))
                $.notify("{!! Session::get('error') !!}", {
                    className: "error",
                    autoHideDelay: 15000,
                    position: "top center"
                });
            @endif

            @if (Session::has('success'))
                $.notify("{!! Session::get('success') !!}", {
                    className: "success",
                    autoHideDelay: 15000,
                    position: "top center"
                });
            @endif

            @if (Session::has('info'))
                $.notify("{!! Session::get('info') !!}", {
                    className: "info",
                    autoHideDelay: 15000,
                    position: "top center"
                });
            @endif

            $('.modal-dialog').draggable({
                handle: ".modal-header"
            });

            $('.modal-dialog').resizable({});
        });
    </script>
    @stack('js')
    @yield('js')
@stop
