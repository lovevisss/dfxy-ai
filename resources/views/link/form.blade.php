<main id="main" class="form-main">
    <a class="back-link" href="{{ route('link.index') }}">← 返回链接导航</a>
    <div class="form-heading"><p class="eyebrow">CURATE YOUR DIRECTORY</p><h1>{{ $editing ? '编辑链接' : '添加一份好用的收藏' }}</h1><p class="muted">填写网站信息，让好工具更容易被发现。</p></div>
    <form class="editor-panel" action="{{ $editing ? route('link.update', $link) : route('link.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($editing) @method('PUT') @endif
        @if($errors->any())<div class="error-summary" role="alert"><strong>请检查以下内容</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <div class="form-field"><label for="title">网站名称 <span>*</span></label><input id="title" name="title" required maxlength="255" value="{{ old('title', $editing ? $link->title : '') }}" placeholder="例如：在线工具箱">@error('title')<small class="field-error">{{ $message }}</small>@enderror</div>
        <div class="form-field"><label for="url">网站地址 <span>*</span></label><input id="url" name="url" type="url" required maxlength="255" value="{{ old('url', $editing ? $link->url : '') }}" placeholder="https://example.com"><small>支持 http:// 和 https:// 开头的网址。</small>@error('url')<small class="field-error">{{ $message }}</small>@enderror</div>
        <div class="form-field"><label for="desc">一句话介绍</label><textarea id="desc" name="desc" rows="3" maxlength="5000" placeholder="这个网站能帮你做什么？">{{ old('desc', $editing ? $link->desc : '') }}</textarea></div>
        <div class="form-field"><label for="category_id">所属分类</label><select name="category_id" id="category_id"><option value="">未分类</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((string) old('category_id', $editing ? $link->category_id : '') === (string) $category->id)>{{ $category->name }}</option>@endforeach</select></div>
        <div class="form-field"><label for="image_path">网站图标</label><div class="upload-box">@if($editing && $link->image())<img class="image-preview" src="{{ $link->image() }}" alt="当前网站图标">@endif<input id="image_path" name="image_path" type="file" accept="image/png,image/jpeg,image/gif,image/webp"></div><small>JPG、PNG、GIF 或 WebP，最大 2 MB。{{ $editing ? '不选择图片则保留当前图标。' : '未上传时使用名称首字作为图标。' }}</small></div>
        <div class="form-actions"><a class="button" href="{{ route('link.index') }}">取消</a><button class="button primary" type="submit">{{ $editing ? '保存修改' : '添加链接' }} <span aria-hidden="true">↗</span></button></div>
    </form>
</main>
