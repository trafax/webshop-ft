<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index()
    {
        Category::truncate();
        Product::truncate();
        ProductVariation::truncate();

        Excel::import(new ProductsImport, storage_path('app/Zomerbollen_lijst_2020.xlsx'));
    }
}
