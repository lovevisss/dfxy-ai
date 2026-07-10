<?php

namespace App\Http\Controllers;

use App\Models\AiTool;
use App\Models\Category;
use Illuminate\Http\Request;

class AiToolController extends Controller
{
    public function __construct()
    {
        // Public listing remains open, CRUD and manage require login.
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ais = AiTool::latest()->get();
        $categories = Category::where('level', 2)->get();
        return view('aitool.index2', compact('ais','categories' ));
    }

    /**
     * Backend page for maintaining created AiTools.
     */
    public function manage(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $categoryId = $validated['category_id'] ?? null;
        $categories = Category::where('level', 2)->orderBy('name')->get();

        $ais = AiTool::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('aitool.manage', compact('ais', 'categories', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $categories = Category::where('level', 2)->get();
        return view('aitool.create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'path' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'img' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['img'] = '';
        $ai = AiTool::create($data);

        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
            $ai->update(['img' => $ai->image() ?? '']);
        }

        return redirect(route('AiTools.manage'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aiTool = AiTool::findOrFail($id);
        $categories = Category::where('level', 2)->get();

        return view('aitool.edit', compact('aiTool', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $aiTool = AiTool::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'path' => ['required', 'string', 'max:255'],
            'desc' => ['required', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'img' => ['nullable', 'image', 'max:2048'],
        ]);

        $aiTool->update($data);

        if($request->hasFile('img')){
            $aiTool->clearMediaCollection('image');
            $aiTool->addMediaFromRequest('img')->toMediaCollection('image');
            $aiTool->update(['img' => $aiTool->image() ?? '']);
        }

        $redirectRoute = $request->boolean('from_manage') ? 'AiTools.manage' : 'AiTools.index';

        return redirect(route($redirectRoute));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aiTool = AiTool::findOrFail($id);
        $aiTool->clearMediaCollection('image');
        $aiTool->delete();

        return redirect(route('AiTools.manage'));
    }
}
