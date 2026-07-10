@php
    $links = [
        [
            'label' => '首页',
            'href' => route('link.index'),
            'active' => request()->routeIs('link.index'),
        ],
        [
            'label' => '添加分类',
            'href' => route('category.create'),
            'active' => request()->routeIs('category.create'),
        ],
        [
            'label' => '添加链接',
            'href' => route('link.create'),
            'active' => request()->routeIs('link.create'),
        ],
        [
            'label' => 'AI 工具',
            'href' => route('AiTools.index'),
            'active' => request()->routeIs('AiTools.*') || request()->routeIs('category.show'),
        ],
    ];
@endphp

@include('includes.nav-shared', [
    'brandRoute' => route('link.index'),
    'brandText' => '网站导航',
    'links' => $links,
])
