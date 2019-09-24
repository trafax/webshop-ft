<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebshopCategory;

class WebshopCategoryController extends Controller
{
    public function index()
    {
        $categories = WebshopCategory::defaultOrder()->get()->toTree();

        return view('webshop.category.admin.index', compact('categories'));
    }

    public function create()
    {
        $categories = WebshopCategory::defaultOrder()->get()->toTree();

        return view('webshop.category.admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new WebshopCategory();
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol toegevoegd.');
    }

    public function edit(WebshopCategory $category)
    {
        $categories = WebshopCategory::where('id', '!=', $category->id)->defaultOrder()->get()->toTree();

        return view('webshop.category.admin.edit', compact('categories', 'category'));
    }

    public function update(Request $request, WebshopCategory $category)
    {
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol aangepast.');
    }

    public function destroy(WebshopCategory $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $category = WebshopCategory::find($id);
            $category->_lft = $key;
            $category->save();
        }

        WebshopCategory::fixTree();

        return response()->json(['reload' => 'true']);
    }
}
