<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\Variation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, $slug, $url_variations = '')
    {
        $active_variations = [];
        $url_variations = explode('/', $url_variations);
        if ($url_variations)
        foreach ($url_variations as $url_variation)
        {
            if ($url_variation)
            {
                $row_url_variation = explode(':', $url_variation);
                $active_variations[$row_url_variation[0]] = $row_url_variation[1];
            }
        }

        //dd($active_variations);

        if ($request->get('variations'))
        {
            $variation_arguments = [];
            foreach ($request->get('variations') as $variation => $values)
            {
                $variation_argument[] = $variation . ':' . implode(',', $values);
            }

            return redirect()->route('category', [$slug, implode('/', $variation_argument)]);
        }

        $category = Category::where('slug', $slug)->firstOrFail();

        $variations = [];
        $all_products = $category->products()->select('id')->get()->pluck('id');
        $all_variation_ids = ProductVariation::select('variation_id')->whereIn('product_id', $all_products)->groupBy('variation_id')->get()->pluck('variation_id');
        $variations_tmp = Variation::orderBy('sort')->findMany($all_variation_ids);

        foreach ($variations_tmp as $variation)
        {
            $values = ProductVariation::where('variation_id', $variation->id)->whereIn('product_id', $all_products)->groupBy('title')->get(['title', 'slug']);
            $variation->values = $values;
            $variations[] = $variation;
        }

        $products = $category->products()->paginate(10);

        $breadcrumbs = Category::whereAncestorOf($category)->get();

        return view('webshop.category.index', compact('category', 'products', 'breadcrumbs', 'variations', 'active_variations'));
    }
}
