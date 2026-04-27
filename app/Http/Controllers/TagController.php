<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Detection\Exception\MobileDetectException;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @throws MobileDetectException
     */
    public function show(Tag $tag, MobileDetect $detect)
    {
//        dd($tag);
        $isMobile = $detect->isMobile();
        $num = $isMobile ? 2 : 5;
        $ais = $tag->ais;
        $tags = Tag::all();
        return view('ai.index',compact('ais','tags', 'isMobile', 'num'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
