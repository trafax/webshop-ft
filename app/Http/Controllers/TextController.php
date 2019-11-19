<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public static function block($block)
    {
        $content = [];

        foreach ($block->text as $text)
        {
            $translation = Translation::where(['parent_id' => $block->id, 'field' => 'col_'.$text->col])->where('language_key', config('app.locale'))->first();
            $content[$text->col] = $translation ? $translation->value : $text->content;
        }

        return view('text.block', compact('block', 'content'));
    }
}
