<?php 

namespace App\Services;

use App\Enums\GenericStatusEnum;
use App\Http\Requests\{StoreColorRequest, UpdateColorRequest};
use App\Models\{Color, Product};
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class ColorService {

    /**
     * get all sizes
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function get_all_colors() {
        return Color::select([
            'name',
            'title',
            'slug',
            'status',
            'product_id',
            'main_image'
        ])->get();
    }

    /**
     * get one size
     * @param string $slug
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function get_one_color(string $slug) {
        return Color::whereSlug($slug)->select([
            'name',
            'title',
            'slug',
            'status',
            'product_id',
            'main_image'
        ])->first();
    }

    /** create a new color for a given product
     * @param App\Http\Requests\StoreColorRequest $request
     * @param App\Models\Product $product
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function create_new_color(StoreColorRequest $request, Product $product)
    {
        return DB::transaction(function () use($request, $product) {
            $upload_url = Cloudinary::uploadApi()->upload($request['main_image'])['secure_url'];
            return $product->colors()->create([
                'name' => $request['name'],
                'title' => $request['title'],
                'main_image' => $upload_url,
                'status' => GenericStatusEnum::INACTIVE
            ]);
        });
    }

    /** update a color for a given product
     * @param App\Http\Requests\UpdateColorRequest $request
     * @param string $slug
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_color(UpdateColorRequest $request, string $slug)
    {
        return DB::transaction(function () use($request, $slug) {
            $color = Color::whereSlug($slug)->first();
            $upload_url = $color->main_image;

            if($request['main_image'] != null)
            {
                $upload_url = Cloudinary::uploadApi()->upload($request['main_image'])['secure_url'];
            }
            return $color->update([
                'name' => $request['name'] ?? $color->name,
                'title' => $request['title'],
                'main_image' => $upload_url,
                'status' => $request['status'] ?? $color->status
            ]);
        });
    }
}