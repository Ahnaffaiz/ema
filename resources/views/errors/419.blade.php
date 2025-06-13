@extends('errors.layout')

@section('title', 'Page Expired')
@section('code', '419')
@section('code_display')
{!! '4<span class="mx-2 text-violet-500">1</span>9' !!}
@endsection
@section('message', 'Sorry, your session has expired. Please refresh and try again')
