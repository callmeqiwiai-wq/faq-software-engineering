<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('order')->get();
        return view('home', compact('sections'));
    }
}
