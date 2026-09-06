@extends('layouts.link')
@section('title', '管理链接分类')
@section('content')
<main id="main" class="form-main">
    <a class="back-link" href="{{ route('link.index') }}">← 返回链接导航</a>
    <div class="form-heading"><p class="eyebrow">DIRECTORY CATEGORIES</p><h1>管理链接分类</h1><p class="muted">整理网站的归属，让常用资源更容易找到。</p></div>
    @if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
    <div class="category-manager-actions"><a class="button primary" href="{{ route('category.create') }}">＋ 添加分类</a></div>
    <div class="editor-panel category-manager">
        @forelse($categories as $category)
            <div class="category-manager-row"><div><strong>{{ $category->name }}</strong><small>{{ $category->links_count }} 个链接</small></div><a class="button" href="{{ route('category.edit', $category) }}" aria-label="修改分类 {{ $category->name }}">修改</a></div>
        @empty
            <p class="muted">还没有链接分类，添加第一个分类开始整理。</p>
        @endforelse
    </div>
</main>
@endsection
