@extends('layouts.aimaster')

{{-- 引入目标站点核心样式依赖（若项目未全局引入Bootstrap5，需补充） --}}
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* 1. 全局基础样式：匹配目标站点的间距、字体 */
        body {
            font-family: "Microsoft YaHei", Arial, sans-serif;
            background-color: #f5f7fa; /* 目标站点浅灰背景 */
        }

        /* 2. 侧边栏菜单样式：垂直排列、蓝色主题、hover效果 */
        .sidebar-menu {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .sidebar-menu .btn-menu {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 20px;
            margin-bottom: 8px;
            border: none;
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            transition: all 0.3s ease;
            text-align: left;
        }

        .sidebar-menu .btn-menu:hover,
        .sidebar-menu .btn-menu.active {
            background-color: #165DFF; /* 目标站点主蓝色 */
            color: #fff;
        }

        .sidebar-menu .btn-menu i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* 3. AI卡片样式：目标站点的"图片+标题+描述"布局 */
        .ai-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%; /* 保证同排卡片高度一致 */
        }

        .ai-card:hover {
            transform: translateY(-5px); /*  hover向上浮动 */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12); /* 增强阴影 */
        }

        /* 卡片图片：保持16:9比例，填充裁剪 */
        .ai-card-img {
            width: 100%;
            height: 140px; /* 目标站点图片高度 */
            object-fit: cover; /* 图片填充不拉伸 */
        }

        /* 卡片内容区：固定内边距，描述文字溢出省略 */
        .ai-card-body {
            padding: 15px;
        }

        .ai-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            white-space: nowrap; /* 标题不换行 */
            overflow: hidden;
            text-overflow: ellipsis; /* 溢出显示省略号 */
        }

        .ai-card-desc {
            font-size: 13px;
            color: #666; /* 描述文字灰色 */
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* 最多显示3行 */
            -webkit-box-orient: vertical;
            overflow: hidden; /* 溢出省略 */
            min-height: 65px; /* 保证描述区高度一致 */
        }

        /* 4. 响应式适配：匹配目标站点的断点调整 */
        @media (max-width: 991px) {
            /* 中等屏幕：侧边栏横向排列，卡片2列 */
            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 10px;
                margin-bottom: 20px;
            }
            .sidebar-menu .btn-menu {
                min-width: 120px;
                margin-bottom: 0;
                margin-right: 8px;
            }
        }

        @media (max-width: 575px) {
            /* 小屏幕：卡片1列，简化间距 */
            .ai-card-img {
                height: 120px;
            }
            .ai-card-body {
                padding: 12px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="container py-4"> {{-- 容器+上下内边距，匹配目标站点间距 --}}
        <div class="row g-4"> {{-- 行间距：g-4 替代mt-3，更规范 --}}

            {{-- 1. 侧边栏：分类菜单（匹配目标站点左侧导航） --}}
            <div class="col-lg-2 d-none d-lg-block"> {{-- 大屏显示，小屏隐藏（后续响应式会横向展示） --}}
                <div class="sidebar-menu">
                    @foreach($categories as $category)
                        {{-- 菜单按钮：默认白色，hover变蓝，active状态高亮 --}}
                        <a
                            class="btn-menu {{ request()->routeIs('category.show') && request()->route('id') == $category->id ? 'active' : '' }}"
                            href="{{ route('category.show', $category->id) }}"
                        >
                            <i class="{{ $category->class }}"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- 小屏侧边栏：横向滚动菜单（仅小屏显示） --}}
            <div class="col-12 d-lg-none">
                <div class="sidebar-menu">
                    @foreach($categories as $category)
                        <a
                            class="btn-menu {{ request()->routeIs('category.show') && request()->route('id') == $category->id ? 'active' : '' }}"
                            href="{{ route('category.show', $category->id) }}"
                        >
                            <i class="{{ $category->class }}"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- 2. 主内容区：AI卡片列表（匹配目标站点网格布局） --}}
            <div class="col-lg-10"> {{-- 主内容区占10列（目标站点更宽） --}}
                <div class="row g-3"> {{-- 卡片间距：g-3 更紧凑，匹配目标站点 --}}
                    @foreach($ais as $ai)
                        {{-- 卡片列：大屏4列（col-lg-3）、中屏2列（col-md-6）、小屏1列（col-12） --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="{{ $ai->path }}" class="text-decoration-none"> {{-- 去除链接下划线 --}}
                                <div class="ai-card">
                                    {{-- 卡片图片：16:9比例，填充裁剪 --}}
                                    <img
                                        src="{{ $ai->image() }}"
                                        alt="{{ $ai->name }}"
                                        class="ai-card-img"
                                    >
                                    {{-- 卡片内容：标题+描述 --}}
                                    <div class="ai-card-body">
                                        <h3 class="ai-card-title">{{ $ai->name }}</h3>
                                        <p class="ai-card-desc">{{ $ai->desc }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
