<?php

namespace App\Services;

use App\Http\Requests\StoreSizeRequest;
use App\Models\{Color, Size};
use Illuminate\Support\Facades\DB;
use App\Services\StockService;

class SizeService {

    public function __construct(
        public StockService $stockService
    ){}
    /** create a new style
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
}