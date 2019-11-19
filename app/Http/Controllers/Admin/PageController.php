<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('parent_id', '0')->orderBy('sort')->get();

        return view('page.admin.index', compact('pages'));
    }

    public function create()
    {
        $pages = Page::where('parent_id', 0)->orderBy('sort')->get();

        return view('page.admin.create', compact('pages'));
    }

    public function store(Request $request)
    {
        $page = new Page();
        $page->fill($request->all());
        $page->save();

        return redirect()->route('admin.page.edit', $page)->with('message', 'Pagina succesvol toegevoegd.');
    }

    public function edit(Page $page)
    {
        $pages = Page::where('id','!=',$page->id)->where('parent_id', '0')->orderBy('sort')->get();

        return view('page.admin.edit', compact('page', 'pages'));
    }

    public function update(Request $request, Page $page)
    {
        $page->fill($request->all());
        $page->save();

        return redirect()->route('admin.page.index')->with('message', 'Pagina succesvol aangepast.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.page.index')->with('message', 'Pagina succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $page = Page::find($id);
            $page->sort = $key;
            $page->save();
        }
    }

    public function tinymce_links()
    {
        $pages = [];
        foreach (Page::all() as $page)
        {
            $pages[] = [
                'title' => $page->title,
                'value' => '/'.$page->slug
            ];
        }
        return response()->json($pages);
    }
}
