@extends('errors.layout')

@section('title', 'Forbidden')
@section('code', '403')
@section('code_display')
{!! '4<span class="mx-2 text-violet-500">0</span>3' !!}
@endsection
@section('message', 'Sorry, you are forbidden from accessing this page')
