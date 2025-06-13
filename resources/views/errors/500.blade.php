@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')
@section('code_display')
{!! '5<span class="mx-2 text-violet-500">0</span>0' !!}
@endsection
@section('message', 'Server Error, please try again later')
