<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public $category = '';
    public $var_1 = '';
    public $var_2 = '';
    public $var_3 = '';
    public $var_4 = '';
    public $var_5 = '';
    public $var_6 = '';
    public $var_7 = '';
    public $var_8 = '';
    public $var_9 = '';

    public function model(array $row)
    {
        $price = 0;

        // Categorie
        if (! is_numeric($row[0]) && ! is_null($row[0])) {

            $this->var_1 = '';
            $this->var_2 = '';
            $this->var_3 = '';
            $this->var_4 = '';
            $this->var_5 = '';
            $this->var_6 = '';
            $this->var_7 = '';
            $this->var_8 = '';
            $this->var_9 = '';

            $this->category = $row[0];
            $category = Category::create([
                'title' => $this->category,
                'slug' => Str::slug($this->category)
            ]);
            $this->category = $category;

            if (strlen($row[5]) > 1) {
                $this->var_1 = $row[5];
            }
            if (strlen($row[6]) > 1) {
                $this->var_2 = $row[6];
            }
            if (strlen($row[7]) > 1) {
                $this->var_3 = $row[7];
            }
            if (strlen($row[7]) > 1) {
                $this->var_4 = $row[8];
            }
            if (strlen($row[7]) > 1) {
                $this->var_5 = $row[9];
            }
            if (strlen($row[7]) > 1) {
                $this->var_6 = $row[10];
            }
            if (strlen($row[7]) > 1) {
                $this->var_7 = $row[11];
            }
            if (strlen($row[7]) > 1) {
                $this->var_8 = $row[12];
            }
            if (strlen($row[7]) > 1) {
                $this->var_9 = $row[13];
            }
        }

        // Product
        if (is_numeric($row[0]) && ! is_null($row[0])) {
            $product = Product::create([
                'sku' => $row[0],
                'title' => $row[1],
                'price' => $row[5],
            ]);

            $product->categories()->attach($this->category->id);

            // Variaties

            // 47bb2c40-1824-11ea-a73b-77b00fecd5ab <= variation ID
            if ($this->var_1 && $row[5] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_1,
                    'slug' => Str::slug($this->var_1 ?? ''),
                    'fixed_price' => $row[5] ?? 0
                ]);

                $price = $row[5] ?? 0;
            }
            if ($this->var_2 && $row[6] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_2,
                    'slug' => Str::slug($this->var_2 ?? ''),
                    'fixed_price' => $row[6] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[5] ?? 0);
            }
            if ($this->var_3 && $row[7] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_3,
                    'slug' => Str::slug($this->var_3 ?? ''),
                    'fixed_price' => $row[7] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[6] ?? 0);
            }
            if ($this->var_4 && $row[8] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_4,
                    'slug' => Str::slug($this->var_4 ?? ''),
                    'fixed_price' => $row[8] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[8] ?? 0);
            }
            if ($this->var_5 && $row[9] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_5,
                    'slug' => Str::slug($this->var_5 ?? ''),
                    'fixed_price' => $row[9] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[9] ?? 0);
            }
            if ($this->var_6 && $row[10] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_6,
                    'slug' => Str::slug($this->var_6 ?? ''),
                    'fixed_price' => $row[10] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[10] ?? 0);
            }
            if ($this->var_7 && $row[11] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_7,
                    'slug' => Str::slug($this->var_7 ?? ''),
                    'fixed_price' => $row[11] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[11] ?? 0);
            }
            if ($this->var_8 && $row[12] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_8,
                    'slug' => Str::slug($this->var_8 ?? ''),
                    'fixed_price' => $row[12] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[12] ?? 0);
            }
            if ($this->var_9 && $row[13] != 'xx') {
                ProductVariation::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'variation_id' => '47bb2c40-1824-11ea-a73b-77b00fecd5ab',
                    'title' => $this->var_9,
                    'slug' => Str::slug($this->var_9 ?? ''),
                    'fixed_price' => $row[13] ?? 0
                ]);

                $price = $price > 0 ? $price : ($row[12] ?? 0);
            }

            $product->price = $price;
            $product->save();
        }
    }
}
