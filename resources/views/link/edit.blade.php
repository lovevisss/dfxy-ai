@extends('layouts.link')
@section('title', '编辑链接')
@section('content')
    @include('link.form', ['editing' => true])
@endsection
