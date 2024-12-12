@extends('adminlte::page')

@section('title', $title)

@section('content_header')
@stop

@section('content')
    <div style="text-align: center;">
        <p style="font-size: 2rem;">{!! $message !!}!</p>
    </div>
@stop

@section('js')
@stop

@section('css')
    <style>
        .content-wrapper {
            background-color: {{ $color }};
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: hidden;
            min-height: 100vh;
        }
    </style>
@stop
