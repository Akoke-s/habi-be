<?php

namespace App\Services;

use App\Models\{Product, Stock};
use Illuminate\Support\Facades\Log;

class StockService {

    /** create a new Stock for a given product
     * @param App\Models\Product $product
     * @param array $sizes
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_stock(array $sizes, Product $product)
    {
        foreach($sizes as $size) {
            Log::alert($size);
            $product->stocks()->create([
                'sku' => $product->sku,
                'init_qty' => $size['qty'],
                'available_qty' => $size['qty'],
                'sold_qty' => 0,
                'in_cart' => 0,
            ]);
        }
        return;
    }

    /** update available stock qty for a given size
     * @param App\Models\Stock $stock
     * @param int $qty
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_available_stock_qty(int $qty, Stock $stock)
    {
        return $stock->update([
            'available_qty' => $stock->available_qty + $qty,
        ]);
    }
}