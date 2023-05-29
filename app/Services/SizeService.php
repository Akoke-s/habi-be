<?php

namespace App\Services;

use App\Http\Requests\{StoreSizeRequest, UpdateSizeRequest};
use App\Models\{Color, Size};
use Illuminate\Support\Facades\DB;
use App\Services\StockService;

class SizeService {

    public function __construct(
        public StockService $stockService
    ){}
    
    /** create a new size
     * @param App\Http\Requests\StoreSizeRequest $request
     * @param App\Models\Color $color
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function create_new_size(StoreSizeRequest $request, Color $color)
    {
        return DB::transaction(function() use($request, $color) {
            $size = $color->sizes()->create([
                'name' => $request['name'],
                'amount' => $request['amount'],
            ]);

            $this->stockService->create_stock($request['qty'], $size);

            return $size;
        });
    }

    /** update size
     * @param App\Http\Requests\UpdateSizeRequest $request
     * @param App\Models\Size $size
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function update_size(UpdateSizeRequest $request, Size $size)
    {
        return DB::transaction(function() use($request, $size) {
            $updated_size = $size->update([
                'name' => $request['name'] ?? $size->name,
                'amount' => $request['amount'] ?? $size->amount,
            ]);
            
            if($request['add_qty'] != null) {
                $this->stockService->update_available_stock_qty($request['add_qty'], $size->stock);
            }

            return $updated_size;
        });
    }
}