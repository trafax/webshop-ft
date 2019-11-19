<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Language;
use App\Models\Text;
use App\Models\Translation;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function edit(Block $block)
    {
        return view('text.admin.edit', compact('block'));
    }

    public function update(Block $block, Request $request)
    {
        $block->fill($request->all());
        $block->save();

        return redirect()->back();
    }

    public function save_text(Block $block, Request $request)
    {
        $language = Language::where('language_key', $request->get('locale'))->where('is_default', 0)->first();

        if ($language)
        {
            Translation::where(['parent_id' => $block->id,
            'field' => 'col_'.$request->get('col'),
            'language_key' => $request->get('locale')])->delete();

            $text = Translation::insert([
                'parent_id' => $block->id,
                'field' => 'col_'.$request->get('col'),
                'language_key' => $request->get('locale'),
                'value' => $request->get('content') ? $request->get('content') : ''
            ]);
        }
        else
        {
            $text = Text::updateOrCreate([
                'parent_id' => $block->id,
                'col' => $request->get('col')
            ], $request->all());
        }
    }
}
