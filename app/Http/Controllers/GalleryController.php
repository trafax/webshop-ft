<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function block($block)
    {
        if ($block)
        {
            $gallery = Gallery::find($block->block_data['gallery_id']);

            return view('gallery.block')->with('gallery', $gallery)->with('block', $block);
        }
    }
}
