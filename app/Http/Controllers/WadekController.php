<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WadekController extends Controller
{
    public function index()
    {
        return view('wakil_dekan.index');
    }
}
