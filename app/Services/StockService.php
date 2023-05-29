<?php 

namespace App\Services;

use App\Models\Size;

class StockService {

    /** create a new Stock for a given size
     * @param App\Models\Size $size
     * @param int $qty
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_stock(int $qty, Size $size) 
    {
        return $size->stock()->create([
            'init_qty' => $qty,
            'available_qty' => 0,
            'sold_qty' => 0,
            'in_cart' => 0,
        ]);
    }
}