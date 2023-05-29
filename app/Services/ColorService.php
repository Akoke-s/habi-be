<?php 

namespace App\Services;

use App\Enums\GenericStatusEnum;
use App\Http\Requests\{StoreColorRequest, UpdateColorRequest};
use App\Models\{Color, Product};
use Illuminate\Support\Facades\DB;

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

    /** update a color for a given product
     * @param App\Http\Requests\UpdateColorRequest $request
     * @param App\Models\Color $color
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_color(UpdateColorRequest $request, Color $color)
    {
        return DB::transaction(function () use($request, $color) {
            return $color->update([
                'name' => $request['name'] ?? $color->name,
                'status' => $request['status'] ?? $color->status
            ]);
        });
    }
}