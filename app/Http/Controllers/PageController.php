<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug = NULL)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page.index');
    }
}
