@extends('layouts.link')
@section('title', '添加链接分类')
@section('content')
    @include('category.form', ['editing' => false])
@endsection
