<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function create(Request $request)
    {
        return view('blocks.admin.create', compact('request'));
    }

    public function store(Request $request)
    {
        $block = new Block();
        $block->fill($request->all());
        $block->save();

        return redirect()->back();
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect()->back();
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $block = Block::find($id);
            $block->sort = $key;
            $block->save();
        }

        return response()->json(['reload' => 'true']);
    }
}
