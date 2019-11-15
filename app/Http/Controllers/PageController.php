<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug = NULL)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $seo = [
            'title' => t($page, 'seo[title]') ? t($page, 'seo[title]') : t($page, 'title'),
            'keywords' => t($page, 'seo[keywords]'),
            'description' => t($page, 'seo[description]')
        ];

        return view('page.index', compact('page', 'seo'));
    }
}
