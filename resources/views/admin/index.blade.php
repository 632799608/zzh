@extends('admin.base')

@section('title', 'Page Title')

@section('sidebar')
    @parent   
@endsection

@section('content')
            @include('admin.public.header')
            @include('admin.public.menu')
@endsection
