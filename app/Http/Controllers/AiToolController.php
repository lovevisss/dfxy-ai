<?php

namespace App\Http\Controllers;

use App\Models\Ai;
use App\Models\AiTool;
use App\Models\Category;
use Illuminate\Http\Request;

class AiToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ais = AiTool::all();
        $categories = Category::where('level', 2)->get();
        return view('aitool.index2', compact('ais','categories' ));
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
        $ai = AiTool::create($request->all());
        if($request->hasFile('img')){
            $ai->clearMediaCollection('image');
            $ai->addMediaFromRequest('img')->toMediaCollection('image');
        }


        return redirect(route('AiTools.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AiTool $aiTool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AiTool $aiTool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AiTool $aiTool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AiTool $aiTool)
    {
        //
    }
}
