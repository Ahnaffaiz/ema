@extends('errors.layout')

@section('title', 'Unauthorized')
@section('code', '401')
@section('code_display')
{!! '4<span class="mx-2 text-violet-500">0</span>1' !!}
@endsection
@section('message', 'Sorry, you are not authorized to access this page')
