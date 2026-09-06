<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '链接导航') · 东方学院</title>
    <link rel="stylesheet" href="{{ asset('css/link-directory.css') }}?v={{ filemtime(public_path('css/link-directory.css')) }}">
    <script src="{{ asset('js/link-directory.js') }}?v={{ filemtime(public_path('js/link-directory.js')) }}" defer></script>
</head>
<body class="@yield('body-class', 'editor-page')">
<a class="skip-link" href="#main">跳转到内容</a>
<header class="topbar">
    <a class="brand" href="{{ route('link.index') }}"><span class="brand-mark">@include('link.icon', ['icon' => 'compass'])</span><span>东方导航<small>DFXY NAVIGATION</small></span></a>
    <nav class="topnav" aria-label="主导航"><a class="current" href="{{ route('link.index') }}">链接导航</a><a href="{{ route('ai.index') }}">AI 助手</a></nav>
    <div class="account">
        @auth
            <span class="account-name">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="post">@csrf<button class="text-button" type="submit">退出</button></form>
            <a class="button primary" href="{{ route('link.create') }}">＋ 添加链接</a>
        @else
            <a class="button primary" href="{{ route('link.create') }}">登录管理 <span aria-hidden="true">↗</span></a>
        @endauth
    </div>
</header>
@yield('content')
<footer class="page-footer"><span>东方导航 · 让好用的网站，触手可及。</span><a href="#main">回到顶部 ↑</a></footer>
</body>
</html>
