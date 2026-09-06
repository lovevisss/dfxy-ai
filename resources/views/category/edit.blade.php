@extends('layouts.link')
@section('title', '修改链接分类')
@section('content')
    @include('category.form', ['editing' => true])
@endsection
