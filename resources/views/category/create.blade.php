@extends('layouts.master')


@section('content')

    <div class="mt-2">

    <h1>添加分类</h1>
    <div class="mt-5 flex-wrap">
    <form action="/category" method="post" class="flex-wrap">
        {{ csrf_field() }}


        <div class="mb-6">
            <label class="form-label">名称</label>
            <input type="text" class="form-control" name="name" placeholder="Input placeholder" />
        </div>


        <div class="mb-6">
            <label class="form-label">等级</label>
            <input type="text" class="form-control" name="level" placeholder="一级目录"  />
        </div>
        <div class="mb-6">
            <label class="form-label">父分类</label>
            <input type="text" class="form-control" name="parent_id" placeholder="父分类的ID"  />
        </div>

        <input type="submit" value="submit" class="btn btn-primary">
    </form>




        {{--    <ul>--}}
{{--        @foreach($links as $link)--}}
{{--            <li>--}}
{{--                <a href="{{ $link->url }}">{{ $link->title }}</a>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
    </div>
    </div>
@endsection
