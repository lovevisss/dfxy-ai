

<nav class="navbar navbar-expand-lg" style="background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
    <div class="container px-4 px-lg-5">
        {{-- 1. 网站Logo/导航标题：匹配目标站点蓝色文字+加粗风格 --}}
        <img src="{{asset('assets/img/logo.png')}}" style="/* 1. 控制Logo尺寸：高度匹配导航栏（避免过高/过矮），宽度自动保持比例 */
                height: 108px;
                width: auto;
                /* 2. 防变形：确保图片拉伸时不扭曲 */
                object-fit: contain;
                /* 3. 位置对齐：与文字导航垂直居中（关键！避免上下错位） */
                vertical-align: middle;
                /* 4. 间距控制：与右侧文字导航保持合理距离（避免拥挤） */
                margin-right: 12px;
                /* 5. 容错：图片加载失败时显示空白（避免破碎图标） */
                display: inline-block;
            "
             alt="网站Logo">
        <a class="navbar-brand" href="{{ route('AiTools.index') }}" style="color: #000; font-size: 18px; font-weight: 600; margin-left: 2em;">
            浙江财经大学东方学院AI工具站 <!-- 建议替换为实际站点名称，如“AI工具导航”，更贴合目标站点 -->
        </a>

        {{-- 2. 移动端菜单按钮：优化图标和样式，匹配目标站点简洁风格 --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"
                style="border-color: #eee;">
            {{-- 替换为Bootstrap图标（避免依赖Font Awesome，与目标站点图标风格统一） --}}
            <i class="bi bi-list" style="color: #666; font-size: 18px;"></i>
        </button>

        {{-- 3. 导航菜单容器：修复原代码class缺失问题，添加展开动画 --}}
        <div class="collapse navbar-collapse" id="navbarResponsive" style="transition: all 0.3s ease;">
            {{-- 右侧菜单：优化间距、 hover效果，匹配目标站点交互 --}}
            <ul class="navbar-nav ms-auto py-2 py-lg-0">
                {{-- 隐藏的“添加分类”按钮（如需显示，保持风格统一） --}}
                {{-- <li class="nav-item">
                    <a class="nav-link px-lg-3 py-2 py-lg-3" href="{{ route('category.create') }}"
                       style="color: #333; font-size: 14px; transition: color 0.2s ease;">
                        添加分类
                    </a>
                </li> --}}
                {{-- “添加链接”按钮：hover变主蓝色，匹配目标站点交互 --}}
                <li class="nav-item">
                    <a class="nav-link px-lg-3 py-2 py-lg-3" href="{{ route('AiTools.create') }}"
                       style="color: #333; font-size: 14px; transition: color 0.2s ease;">
                        添加链接
                    </a>
                </li>
                {{-- （可选）补充目标站点常见的“首页”导航，保持菜单完整性 --}}
                <li class="nav-item">
                    <a class="nav-link px-lg-3 py-2 py-lg-3" href="{{ route('AiTools.index') }}"
                       style="color: {{ request()->routeIs('AiTools.index') ? '#165DFF' : '#333' }}; font-size: 14px; transition: color 0.2s ease;">
                        首页
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
