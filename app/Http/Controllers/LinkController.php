<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    public function index()
    {
        $categories = Category::with('links.media')->orderBy('id')->get();
        $uncategorized = Link::with('media')->whereDoesntHave('category')->get();

        return view('link.index', compact('categories', 'uncategorized'));
    }

    public function create()
    {
        return view('link.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $link = Link::create($this->validatedData($request));
        if ($request->hasFile('image_path')) {
            $link->addMediaFromRequest('image_path')->toMediaCollection('image');
        }

        return redirect()->route('link.index')->with('status', '链接已添加');
    }

    public function show(Link $link)
    {
        return redirect()->route('link.index');
    }

    public function edit(Link $link)
    {
        return view('link.edit', ['link' => $link, 'categories' => Category::all()]);
    }

    public function update(Request $request, Link $link)
    {
        $data = $this->validatedData($request, $link);
        if ($request->hasFile('image_path')) {
            $previousImages = $link->getMedia('image');
            $link->addMediaFromRequest('image_path')->toMediaCollection('image');
            $previousImages->each->delete();
        }
        $link->update($data);

        return redirect()->route('link.index')->with('status', '链接已更新');
    }

    public function destroy(Link $link)
    {
        // Deletion is not exposed by the link management interface.
        abort(405);
    }

    private function validatedData(Request $request, ?Link $link = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url:http,https', 'max:255', Rule::unique('links')->ignore($link?->id)],
            'desc' => ['nullable', 'string', 'max:5000'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);
        unset($data['image_path']);

        return $data;
    }
}
