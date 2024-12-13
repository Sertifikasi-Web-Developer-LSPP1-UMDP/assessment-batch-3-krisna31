@extends('adminlte::page')

@section('title', 'Update Password')

@section('content_header')
@stop

@section('content')

    <div class="card mt-2 py-3 pb-2">
        <div class="card-header">
            <a href="{{ route('home') }}" class="btn btn-light btn-xs pull-left"> <i class="fas fa-arrow-alt-circle-left"></i>Home</a>
        </div>

        <div class="row card-body mx-5">
            <form action="{{ route('updatePassword') }}" method="post" class="w-100" autocomplete="off">
                @method('PATCH')
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ auth()->user()->name }}" autofocus readonly>

                    @if ($errors->has('name'))
                        <div id="name" class="text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ auth()->user()->email }}" readonly>

                    @if ($errors->has('email'))
                        <div id="email" class="text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <div clas="control mb-4">
                        <div class="input-group">
                            <input type="password" name="password" id="password" minlength="10" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" autocomplete="new-password" />
                            <span class="input-group-text">
                                <span data-target="#password" class=" fa fa-eye-slash"></span>
                            </span>
                        </div>

                        @if ($errors->has('password'))
                            <div id="password" class="text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation:</label>
                    <div clas="control mb-4">
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" minlength="10" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" />
                            <span class="input-group-text">
                                <span data-target="#password_confirmation" class="pw-toggle2 fa fa-eye-slash"></span>
                            </span>
                        </div>

                        @if ($errors->has('password'))
                            <div id="password" class="text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row pull-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('css')
    <style>
        .input-group-text {
            cursor: pointer;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $("span.input-group-text").click(function() {
                const $passwordField = $($(this).find('span').data().target);
                const textOrPassword = $passwordField.attr('type') == 'password' ? 'text' : 'password';
                $(this).find('span').toggleClass('fa-eye-slash fa-eye');
                $passwordField.attr('type', textOrPassword);
            });
        });
    </script>
@endpush
