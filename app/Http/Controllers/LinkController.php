<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{

    public function __construct()
    {
//        share data on all

        view()->share('categories', Category::all() );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('level' ,1)->get();
        $links = Link::all();
        return view('link.index', compact('links', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('link.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $link = Link::create($request->all());
        if($request->hasFile('image_path')){
            $link->clearMediaCollection('image');
            $link->addMediaFromRequest('image_path')->toMediaCollection('image');
        }


        return redirect(route('link.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link, Request $request)
    {
        return view('link.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
//        dd($request->hasFile('image_path'));
        if($request->hasFile('image_path')){
            $link->clearMediaCollection('image');
            $link->addMediaFromRequest('image_path')->toMediaCollection('image');
        }
//        $link->addMedia($request->file)->toMediaCollection('image');

        $link->update($request->all());

        return redirect(route('link.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
