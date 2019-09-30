<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $variations = [];
        $variationProducts = $category->products()->with('variations')->get()->pluck('variations');
        foreach ($variationProducts as $variationProduct)
        {
            foreach ($variationProduct as $variation)
            {
                $variations[$variation->title][Str::slug($variation->pivot->title)] = $variation;
            }
        }
        $products = $category->products()->paginate(10);

        $breadcrumbs = Category::whereAncestorOf($category)->get();

        return view('webshop.category.index', compact('category', 'products', 'breadcrumbs', 'variations'));
    }
}
