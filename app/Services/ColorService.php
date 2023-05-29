<?php 

namespace App\Services;

use App\Enums\GenericStatusEnum;
use App\Http\Requests\StoreColorRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ColorService {

    /** create a new color for a given product
     * @param App\Http\Requests\StoreColorRequest $request
     * @param App\Models\Product $product
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function create_new_color(StoreColorRequest $request, Product $product)
    {
        return DB::transaction(function () use($request, $product) {
            return $product->colors()->create([
                'name' => $request['name'],
                'status' => GenericStatusEnum::INACTIVE
            ]);
        });
    }
}