<?php

namespace App\Http\Controllers;

use App\Models\Ai;
use App\Models\Link;
use App\Models\Tag;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class AiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MobileDetect $detect)
    {
        $ais = Ai::all();

        $tags = Tag::all();
        $isMobile = $detect->isMobile();
        $num = $isMobile ? 2 : 5;
        return view('ai.index',compact('ais','tags','num'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ai = Ai::create($request->all());
        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
        }


        return redirect(route('ai.index'));
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
        return view('ai.edit',compact('ai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ai $ai)
    {
        $ai->update(
            $request->only('name','desc')
        );
        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
        }

        if ($request->has('tags')) {
            $ai->tags()->attach($request->tags);
        }
        return redirect(route('link.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ai $ai)
    {
        //
    }
}
