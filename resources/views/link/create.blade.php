@extends('layouts.link')
@section('title', '添加链接')
@section('content')
    @include('link.form', ['editing' => false])
@endsection
