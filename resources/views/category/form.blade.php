<main id="main" class="form-main">
    <a class="back-link" href="{{ route('category.index') }}">← 返回分类管理</a>
    <div class="form-heading"><p class="eyebrow">DIRECTORY CATEGORIES</p><h1>{{ $editing ? '修改链接分类' : '添加链接分类' }}</h1><p class="muted">{{ $editing ? '更新分类名称，分类下的链接会继续保留。' : '为网站创建一个清晰易懂的分类。' }}</p></div>
    <form class="editor-panel" action="{{ $editing ? route('category.update', $category) : route('category.store') }}" method="post">
        @csrf
        @if($editing) @method('PUT') @endif
        <div class="form-field"><label for="name">分类名称 <span>*</span></label><input id="name" name="name" required maxlength="255" value="{{ old('name', $editing ? $category->name : '') }}" placeholder="例如：后台管理、常用工具" @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>@error('name')<small id="name-error" class="field-error" role="alert">{{ $message }}</small>@enderror</div>
        <div class="form-actions"><a class="button" href="{{ route('category.index') }}">取消</a><button class="button primary" type="submit">{{ $editing ? '保存修改' : '添加分类' }}</button></div>
    </form>
</main>
