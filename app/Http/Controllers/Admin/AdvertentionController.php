<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class AdvertentionController extends Controller
{
    public function edit(Block $block)
    {
        return view('advertention.admin.edit', compact('block'));
    }

    public function update(Request $request, Block $block)
    {
        $block->fill(array_merge($request->all(), ['block_data' => $request->get('block_data')]));
        $block->save();

        return redirect()->back();
    }
}
