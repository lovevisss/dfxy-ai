<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AI 智能体</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/tabler.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/tabler.min.css') }}">
    <style>
        body {
            background: #f6f8fb;
            color: #182230;
        }

        .ai-hero {
            background: linear-gradient(135deg, #ffffff 0%, #eef6ff 55%, #e9f8f1 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .ai-hero-title {
            font-size: clamp(2rem, 4vw, 3.75rem);
            font-weight: 800;
            line-height: 1.05;
        }

        .ai-toolbar {
            gap: .75rem;
        }

        .ai-tag {
            border: 1px solid #dbe3ef;
            color: #31506f;
            background: #ffffff;
            transition: all .2s ease;
        }

        .ai-tag:hover {
            border-color: #206bc4;
            color: #206bc4;
            transform: translateY(-1px);
        }

        .ai-card {
            height: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(16, 24, 40, .06);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .ai-card:hover {
            border-color: #b6cff0;
            box-shadow: 0 18px 45px rgba(16, 24, 40, .12);
            transform: translateY(-3px);
        }

        .ai-card-image {
            aspect-ratio: 16 / 9;
            background: #dbeafe center / cover no-repeat;
        }

        .ai-card-body {
            min-height: 190px;
        }

        .ai-card-desc {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            margin-top: .5rem;
        }

        .ai-card .card-title {
            display: block;
            line-height: 1.35;
            word-break: break-word;
        }

        .ai-admin-actions {
            border-top: 1px solid #eef2f7;
            background: #fbfcfe;
        }

        .ai-empty {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
        }
    </style>
</head>
<body>
<main class="page">
    <section class="ai-hero py-5 py-lg-6">
        <div class="container-xl">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="text-uppercase text-primary fw-bold mb-2">AI Assistant Library</div>
                    <h1 class="ai-hero-title mb-3">AI 智能体导航</h1>
                    <p class="text-secondary fs-3 mb-0">
                        汇总常用智能体入口，按标签快速筛选，适合教学、办公与内容创作场景。
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-wrap justify-content-lg-end ai-toolbar">
                        <a class="btn btn-primary" href="https://cloud.zufedfc.edu.cn/ai-knowledge/createPro">
                            创建智能体
                        </a>
                        @auth
                            <a class="btn btn-outline-primary" href="{{ route('ai.create') }}">
                                添加条目
                            </a>
                        @else
                            <a class="btn btn-outline-secondary" href="{{ route('login') }}">
                                登录后维护
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container-xl">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            @if($tags->isNotEmpty())
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($tags as $tag)
                        @php
                            $tagName = trim(preg_replace('/[\s\x{00A0}\x{3000}]+/u', ' ', $tag->name ?? ''));
                        @endphp
                        @if($tag->id != 3 && $tagName !== '')
                            <a class="badge ai-tag text-decoration-none px-3 py-2" href="/tag/{{ $tag->id }}">
                                {{ $tagName }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            @if($ais->isEmpty())
                <div class="ai-empty p-5 text-center">
                    <h2 class="h3 mb-2">暂无 AI 智能体</h2>
                    <p class="text-secondary mb-0">登录后可以添加第一条智能体信息。</p>
                </div>
            @else
                <div class="row row-cards">
                    @foreach($ais as $ai)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card ai-card">
                                <a href="{{ $ai->path ?: '#' }}" class="text-reset text-decoration-none" target="_blank" rel="noopener">
                                    <div
                                        class="ai-card-image"
                                        style="background-image: url('{{ $ai->image() ?: asset('images/banner.png') }}')"
                                    ></div>
                                    <div class="card-body ai-card-body">
                                        @php
                                            $visibleTags = $ai->tags
                                                ->map(function ($tag) {
                                                    $tag->display_name = trim(preg_replace('/[\s\x{00A0}\x{3000}]+/u', ' ', $tag->name ?? ''));
                                                    return $tag;
                                                })
                                                ->filter(fn ($tag) => $tag->display_name !== '');
                                        @endphp
                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            @if($visibleTags->isNotEmpty())
                                                @foreach($visibleTags as $tag)
                                                    <span class="badge {{ $tag->color ?: 'bg-blue-lt' }}">{{ $tag->display_name }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-secondary-lt">未分类</span>
                                            @endif
                                        </div>
                                        <h2 class="card-title h3 mb-2">{{ $ai->name }}</h2>
                                        <p class="text-secondary ai-card-desc mb-0">{{ $ai->desc }}</p>
                                    </div>
                                </a>

                                @auth
                                    <div class="ai-admin-actions px-3 py-2 d-flex justify-content-between align-items-center">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('ai.edit', $ai) }}">编辑</a>
                                        <form action="{{ route('ai.destroy', $ai) }}" method="POST" onsubmit="return confirm('确认删除这个 AI 智能体吗？')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">删除</button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>
</body>
</html>
