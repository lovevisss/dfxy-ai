<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function showForm()
    {
        return view('login');
    }

    public function validate(Request $request, array $rules, array $messages = [], array $attributes = [])
    {
//        print_r($request->all());
        $this->validate($request, [
            'username' => 'required|max:8',
            'password' => 'required',


        ]);
    }
}
