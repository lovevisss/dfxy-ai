<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('welcome', compact('posts'));
    }

    public function show(){
        return view('post.show');
    }



    public function contactPost(Request $request){
        $file = $request->file('attachment');
        echo $file->getClientOriginalName();
        $file->move('images', $file->getClientOriginalName());
        $email = $request->get('email');
        dd($email);
//        var_dump($request->all());
    }
}
