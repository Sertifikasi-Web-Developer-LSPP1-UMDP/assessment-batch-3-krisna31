@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Selamat Datang {{ auth()->user()->email }}, Semoga Hari Anda Menyenangkan</p>

    <hr>

    <p>Status Pendaftaran Anda : {{ auth()->user()->status_pendaftaran }}</p>
@stop

@section('css')
@stop

@section('js')
@stop
