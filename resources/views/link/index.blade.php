@extends('layouts.link')
@section('body-class', 'directory-page')
@section('content')
@php
    $groups = $categories->map(fn ($category) => ['id' => 'category-'.$category->id, 'name' => $category->name, 'links' => $category->links]);
    if ($uncategorized->isNotEmpty()) $groups->push(['id' => 'uncategorized', 'name' => '未分类', 'links' => $uncategorized]);
    $total = $groups->sum(fn ($group) => $group['links']->count());
@endphp
<div class="directory-shell">
    <aside class="sidebar">
        <div class="sidebar-title">校园数字工作台<span>THE DIRECTORY</span></div>
        <a class="sidebar-home" href="{{ route('link.index') }}">@include('link.icon', ['icon' => 'grid'])<span>全部网站</span><small>{{ $total }}</small></a>
        <p class="nav-label">探索分类 <span>CATEGORIES</span></p>
        <nav aria-label="链接分类">
            @foreach($groups as $group)
                <a href="#{{ $group['id'] }}" data-category-nav><span class="nav-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span>{{ $group['name'] }}</span><small>{{ $group['links']->count() }}</small></a>
            @endforeach
        </nav>
        <div class="sidebar-note"><span class="note-symbol" aria-hidden="true">✳</span><strong>少一点寻找，<br>多一点创造。</strong><p>把值得访问的网站，<br>留在触手可及的地方。</p><a href="{{ route('link.create') }}">@auth 分享一个好网站 @else 登录，开始整理 @endauth <span aria-hidden="true">↗</span></a></div>
        <div class="sidebar-bottom"><span class="status-dot"></span> 东方学院 · 资源导航</div>
    </aside>
    <main id="main" class="directory-main">
        <section class="discovery-hero">
            <div class="hero-content">
                <p class="eyebrow"><span></span> 校园资源 · 高效协作</p>
                <h1>常用系统，<span>一站直达。</span></h1>
                <p class="intro-copy">业务系统、管理平台与常用工具。<br class="mobile-break">连接校园工作的每一个日常。</p>
                <form class="searchbar" role="search" data-search-form>
                    @include('link.icon', ['icon' => 'search'])
                    <label class="sr-only" for="link-search">搜索链接</label>
                    <input id="link-search" type="search" placeholder="搜索系统、平台或网址…" autocomplete="off">
                    <kbd aria-hidden="true">/</kbd><button class="button primary" type="submit">搜索 @include('link.icon', ['icon' => 'arrow'])</button>
                </form>
                <div class="quick-categories"><span>快捷发现</span>@foreach($groups->take(4) as $group)<a href="#{{ $group['id'] }}" data-category-nav>{{ $group['name'] }} <span aria-hidden="true">↗</span></a>@endforeach</div>
            </div>
            <div class="hero-art" aria-hidden="true"><div class="art-grid"></div><span class="art-orbit orbit-one"></span><span class="art-orbit orbit-two"></span><div class="art-tile tile-large">@include('link.icon', ['icon' => 'compass'])<span>EXPLORE<br>SOMETHING GOOD.</span></div><div class="art-tile tile-small">↗</div><span class="art-spark">✳</span><div class="art-caption">让每一次访问更简单 <span>↗</span></div></div>
        </section>
        <div class="directory-toolbar"><div><h2>探索网站</h2><span>{{ $total }} 个网站 <i></i> {{ $groups->count() }} 个分类</span></div><span class="browse-state">@auth <span class="status-dot"></span> 已登录 · 可编辑 @else @include('link.icon', ['icon' => 'globe']) 自由访问，登录后可编辑 @endauth</span></div>
        @if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
        <p class="search-status muted" data-search-status role="status" aria-live="polite" hidden></p>
        @foreach($groups as $group)
            <section class="category-section" id="{{ $group['id'] }}" data-link-group>
                <div class="section-heading"><h2><span class="section-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $group['name'] }}<span class="count">{{ $group['links']->count() }}</span></h2><span class="section-caption">发现值得收藏的网站 @include('link.icon', ['icon' => 'arrow'])</span></div>
                <div class="link-grid">
                    @foreach($group['links'] as $link)
                        @php
                            $safeUrl = in_array(strtolower(parse_url($link->url, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true);
                            $hostname = parse_url($link->url, PHP_URL_HOST) ?: '网址待完善';
                        @endphp
                        <article class="link-card" data-link-card data-search="{{ $link->title }} {{ $link->desc }} {{ $link->url }} {{ $group['name'] }}">
                            <a class="resource-link" href="{{ $safeUrl ? $link->url : '#' }}" @if($safeUrl) target="_blank" rel="noopener noreferrer" @endif title="{{ $link->title }} — {{ $link->desc }}">
                                <div class="card-top"><span class="site-icon">@if($link->image())<img src="{{ $link->image() }}" alt="" loading="lazy">@else{{ mb_substr($link->title, 0, 1) }}@endif</span><span class="card-identity"><strong>{{ $link->title }}</strong><span>{{ $hostname }}</span></span><span class="outbound">@include('link.icon', ['icon' => 'arrow'])</span></div>
                                <p class="card-description">{{ $link->desc ?: '从这里出发，发现更多实用内容。' }}</p>
                                <div class="card-bottom"><span>{{ $group['name'] }}</span><span>{{ $safeUrl ? '访问网站' : '地址待完善' }} <span aria-hidden="true">↗</span></span></div>
                            </a>
                            @auth<a class="edit-link" href="{{ route('link.edit', $link) }}" aria-label="编辑 {{ $link->title }}">@include('link.icon', ['icon' => 'edit']) 编辑</a>@endauth
                        </article>
                    @endforeach
                </div>
                @if($group['links']->isEmpty())<p class="category-empty muted">这个分类还没有链接。</p>@endif
            </section>
        @endforeach
        <div class="empty-state" data-empty @if($total > 0) hidden @endif>@include('link.icon', ['icon' => 'search'])<h2>{{ $total ? '没有找到匹配的链接' : '等待第一份收藏' }}</h2><p>{{ $total ? '换个关键词试试，或清空搜索查看全部链接。' : '添加常用网站，从这里开启高效的一天。' }}</p>@if($total)<button class="button" type="button" data-clear-search>清空搜索</button>@else<a class="button primary" href="{{ route('link.create') }}">@auth 添加链接 @else 登录添加链接 @endauth</a>@endif</div>
        <div class="collection-note"><span>好用的网站，值得被更多人发现。</span><a href="{{ route('link.create') }}">@auth 添加你的收藏 @else 登录分享好站 @endauth <span aria-hidden="true">↗</span></a></div>
    </main>
</div>
@endsection
