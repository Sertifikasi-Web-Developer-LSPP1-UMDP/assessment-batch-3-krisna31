@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Selamat Datang {{ auth()->user()->email }}, Semoga Hari Anda Menyenangkan</p>
@stop

@section('css')
@stop

@section('js')
@stop
