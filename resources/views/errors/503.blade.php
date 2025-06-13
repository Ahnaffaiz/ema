@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('code_display')
{!! '5<span class="mx-2 text-violet-500">0</span>3' !!}
@endsection
@section('message', 'Sorry, we are doing some maintenance. Please check back soon')
