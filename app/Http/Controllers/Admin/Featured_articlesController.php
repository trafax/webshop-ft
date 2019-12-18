<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class Featured_articlesController extends Controller
{
    public function edit(Block $block)
    {
        return view('webshop.blocks.admin.edit_featured_articles', compact('block'));
    }

    public function update(Request $request, Block $block)
    {
        $block->fill(array_merge($request->all(), ['block_data' => $request->get('block_data')]));
        $block->save();

        return redirect()->back();
    }
}
