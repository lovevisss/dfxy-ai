@extends('layouts.master')


@section('content')

    <div class="mt-2">

        <h1>添加链接</h1>
        <div class="mt-5 flex-wrap">
            <form action="{{route('link.update', $link->id)}}" method="post" class="flex-wrap" enctype="multipart/form-data" >
                {{ csrf_field() }}
                @method('PUT')
                <div class="flex justify-center" onclick="document.getElementById('image').click()" >
                    <img src="" alt="" class="rounded-full h-40 w-40 object-cover border-gray-100 border-2  bg-gray-400 hover:border-0">
                </div>
                <div class="mb-6 flex-wrap">
                    <label class="form-label">图片</label>
                    <input onchange="document.getElementById('update-channel-form').submit()" id="image" type="file" name="image_path" >

                </div>
                <div class="mb-6">
                    <label class="form-label">名称</label>
                    <input type="text" class="form-control" name="title" placeholder="Input placeholder" value="{{$link->title}}" />
                </div>
                <div class="mb-6">
                    <label class="form-label">URL</label>
                    <input type="text" class="form-control" name="url" placeholder="Input placeholder"  value="{{$link->url}}" />
                </div>
                <div class="mb-6 flex-wrap">
                    <label class="form-label">描述</label>
                    <textarea type="text" class="form-control" name="desc" placeholder="Input placeholder" rows="6"  >{{$link->desc}}</textarea>
                </div>
                <div class="mb-6">
                    <label class="form-label">分类</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$category->id === $link->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
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
