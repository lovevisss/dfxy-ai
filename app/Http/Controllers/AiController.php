<?php

namespace App\Http\Controllers;

use App\Models\Ai;
use App\Models\Tag;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(MobileDetect $detect)
    {
        $ais = Ai::with('tags')->latest()->get();

        $tags = Tag::orderBy('name')->get();
        $isMobile = $detect->isMobile();
        return view('ai.index',compact('ais','tags','isMobile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('ai.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'path' => ['nullable', 'string', 'max:255'],
            'desc' => ['nullable', 'string', 'max:1000'],
            'img' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ]);

        $tags = $data['tags'] ?? [];
        unset($data['img'], $data['tags']);

        $ai = Ai::create($data);
        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
            $ai->update(['img' => $ai->image() ?? '']);
        }

        $ai->tags()->sync($tags);

        return redirect(route('ai.index'))->with('status', 'AI 智能体已添加');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ai $ai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ai $ai)
    {
        $tags = Tag::orderBy('name')->get();

        return view('ai.edit',compact('ai', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ai $ai)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'path' => ['nullable', 'string', 'max:255'],
            'desc' => ['nullable', 'string', 'max:1000'],
            'img' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ]);

        $tags = $data['tags'] ?? [];
        unset($data['img'], $data['tags']);

        $ai->update($data);
        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
            $ai->update(['img' => $ai->image() ?? '']);
        }

        $ai->tags()->sync($tags);

        return redirect(route('ai.index'))->with('status', 'AI 智能体已更新');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ai $ai)
    {
        $ai->clearMediaCollection('image');
        $ai->tags()->detach();
        $ai->delete();

        return redirect(route('ai.index'))->with('status', 'AI 智能体已删除');
    }
}
