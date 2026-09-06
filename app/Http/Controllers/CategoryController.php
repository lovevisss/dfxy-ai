<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function index()
    {
        $categories = Category::where('level', 1)->withCount('links')->orderBy('id')->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        Category::create($data + ['level' => 1, 'parent_id' => 0]);

        return redirect()->route('category.index')->with('status', '链接分类已添加');
    }

    public function show(Category $category)
    {
        abort_unless((int) $category->level === 2, 404);
        $ais = $category->aitools;
        $categories = Category::where('level', 2)->get();

        return view('aitool.index2', compact('ais', 'categories'));
    }

    public function edit(Category $category)
    {
        abort_unless((int) $category->level === 1, 404);

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_unless((int) $category->level === 1, 404);
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $category->update($data);

        return redirect()->route('category.index')->with('status', '链接分类已更新');
    }

    public function destroy(Category $category)
    {
        abort(405);
    }
}
