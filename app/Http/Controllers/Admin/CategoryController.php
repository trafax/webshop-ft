<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::defaultOrder()->get()->toTree();

        return view('webshop.category.admin.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::defaultOrder()->get()->toTree();

        return view('webshop.category.admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol toegevoegd.');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->defaultOrder()->get()->toTree();

        return view('webshop.category.admin.edit', compact('categories', 'category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol aangepast.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('message', 'Categorie succesvol verwijderd.');
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id)
        {
            $category = Category::find($id);
            $category->_lft = $key;
            $category->save();
        }

        Category::fixTree();

        return response()->json(['reload' => 'true']);
    }
}
