<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.role:role');
    }

    public function index(){
        return view('admin.index');
    }
}
