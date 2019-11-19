<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class ParallaxController extends Controller
{
    public function edit(Block $block)
    {
        return view('parallax.admin.edit', compact('block'));
    }

    public function update(Block $block, Request $request)
    {
        $block->fill($request->all());
        $block->save();

        return redirect()->back();
    }
}
