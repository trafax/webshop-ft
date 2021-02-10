<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View as View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('webshop.exports.products', [

        ]);
    }
}
