@extends('layouts.master')


@section('content')

    <div class="mt-2 page-body">
        <div class="container-lg">
            <div class="row row-card">
                <div class="col-12">
                    <div class="card-header">
                        编辑AI工具
                    </div>
                    <div class="mt-5 row  ">
                        <form action="/AiTools/{{ $aiTool->id }}" method="post" class="flex-wrap" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="flex justify-center" onclick="document.getElementById('image').click()" >
                                <img src="{{ $aiTool->img_url }}" alt="" class="rounded-full h-40 w-40 object-cover border-gray-100 border-2  bg-gray-400 hover:border-0">
                            </div>

                            <div class="mb-6 flex-wrap ">
                                <label class="form-label">图片</label>
                                <input onchange="document.getElementById('update-channel-form').submit()" id="image" type="file" name="img" >
                            </div>
                            <div class="mb-6  col-md-6">
                                <label class="form-label">名称</label>
                                <input type="text" class="form-control" name="name" placeholder="Input placeholder" value="{{ $aiTool->name }}" />
                            </div>
                            <div class="mb-6  col-md-6">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" name="path" placeholder="Input placeholder" value="{{ $aiTool->path }}"  />
                            </div>
                            <div class="mb-6 flex-wrap">
                                <label class="form-label">描述</label>
                                <textarea type="text" class="form-control" name="desc" placeholder="Input placeholder" rows="6"  >{{ $aiTool->desc }}</textarea>
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="category_id">分类</label>
                                <select name="category_id" id="category_id" class="select-all form-control mb-2">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected($aiTool->category_id == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" value="submit" class="btn btn-primary mt-2">
                        </form>

                </div>

            </div>

        </div>


    </div>
@endsection

@section('footer')
    <script >
        $(document).ready(function() {
            $('.select-all').select2();
        });
    </script>
@endsection
