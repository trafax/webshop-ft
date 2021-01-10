<?php

namespace App\Http\Controllers;

use App\Models\Block;

class AdvertentionController extends Controller
{
    public function block(Block $block)
    {
        return view('advertention.block', compact('block'));
    }
}
