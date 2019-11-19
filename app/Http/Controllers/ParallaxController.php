<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParallaxController extends Controller
{
    public function block($block)
    {
        return view('parallax.block', compact('block'));
    }
}
