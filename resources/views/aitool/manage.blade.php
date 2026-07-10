@extends('layouts.master')

@section('content')
    <div class="mx-auto w-full max-w-7xl px-4 py-8">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">AiTools 后台维护</h1>
                <p class="mt-1 text-sm text-gray-500">管理已创建的工具，支持编辑与删除。</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('AiTools.manage') }}" method="get" class="flex flex-wrap items-center gap-2">
                    <select name="category_id" class="rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option value="">全部分类</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-md border border-indigo-200 bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100">
                        筛选
                    </button>
                    @if($categoryId)
                        <a href="{{ route('AiTools.manage') }}" class="rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">
                            重置
                        </a>
                    @endif
                </form>

                <a href="{{ route('AiTools.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    新增工具
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">封面</th>
                        <th class="px-4 py-3">名称</th>
                        <th class="px-4 py-3">分类</th>
                        <th class="px-4 py-3">链接</th>
                        <th class="px-4 py-3">操作</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse($ais as $ai)
                        <tr>
                            <td class="px-4 py-3">
                                <img
                                    src="{{ $ai->image() ?? 'https://placehold.co/200x112?text=No+Image' }}"
                                    alt="{{ $ai->name }}"
                                    class="h-14 w-24 rounded-md object-cover ring-1 ring-gray-200"
                                >
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $ai->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ optional($ai->category)->name ?? '-' }}</td>
                            <td class="max-w-xs truncate px-4 py-3 text-gray-600">{{ $ai->path }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('AiTools.edit', ['AiTool' => $ai]) }}" class="inline-flex items-center rounded-md border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100">
                                        编辑
                                    </a>
                                    <form action="{{ route('AiTools.destroy', ['AiTool' => $ai]) }}" method="post" onsubmit="return confirm('确认删除该工具吗？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">删除</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">暂无 AiTools 数据，先创建一个吧。</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-4 py-3">
                {{ $ais->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

