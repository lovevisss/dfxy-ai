@extends('layouts.master')

@section('content')
    <div class="container-xl py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h1 class="card-title mb-1">编辑 AI 智能体</h1>
                            <div class="text-secondary">{{ $ai->name }}</div>
                        </div>
                    </div>

                    <form action="{{ route('ai.update', $ai) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    请检查表单内容后再提交。
                                </div>
                            @endif

                            @if($ai->image())
                                <div class="mb-3">
                                    <label class="form-label">当前图片</label>
                                    <img src="{{ $ai->image() }}" alt="{{ $ai->name }}" class="rounded border" style="max-width: 280px; width: 100%; height: auto;">
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="name">名称</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $ai->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="path">URL</label>
                                <input id="path" type="url" class="form-control @error('path') is-invalid @enderror" name="path" value="{{ old('path', $ai->path) }}" placeholder="https://">
                                @error('path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="desc">描述</label>
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" rows="5">{{ old('desc', $ai->desc) }}</textarea>
                                @error('desc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="tags">关联标签</label>
                                @php
                                    $selectedTags = old('tags', $ai->tags->pluck('id')->all());
                                @endphp
                                <select name="tags[]" id="tags" class="form-select select-all @error('tags') is-invalid @enderror" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" @selected(in_array($tag->id, $selectedTags))>{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="image">更换图片</label>
                                <input id="image" type="file" class="form-control @error('img') is-invalid @enderror" name="img" accept="image/*">
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-link" href="{{ route('ai.index') }}">返回</a>
                            <button type="submit" class="btn btn-primary">保存修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('.select-all').select2({
                width: '100%'
            });
        });
    </script>
@endsection
