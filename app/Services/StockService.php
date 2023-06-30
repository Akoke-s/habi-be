<?php 

namespace App\Services;

use App\Models\{Size, Stock};

class StockService {

    /** create a new Stock for a given size
     * @param App\Models\Size $size
     * @param int $qty
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_stock(int $qty, Size $size) 
    {
        return $size->stock()->create([
            'sku' => $size->color->product->sku,
            'init_qty' => $qty,
            'available_qty' => $qty,
            'sold_qty' => 0,
            'in_cart' => 0,
        ]);
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