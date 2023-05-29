<?php 

namespace App\Services;

use App\Enums\GenericStatusEnum;
use App\Enums\ProductTypeEnum;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\{StoreProductRequest, UpdateProductRequest};
use App\Models\Product;

class ProductService {

    /** create new product
     * @param App\Http\Requests\StoreProductRequest $productDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_new_product(StoreProductRequest $productDetails) {
        return DB::transaction(function() use ($productDetails) {
            
            $upload_url = Cloudinary::uploadApi()->upload($productDetails['image'])['secure_url'];

            return Product::create([
                'type' => ProductTypeEnum::READY_TO_WEAR,
                'name' => $productDetails['name'],
                'image' => $upload_url,
                'description' => $productDetails['description'],
                'category_id' => $productDetails['category_id'],
                'status' => GenericStatusEnum::ACTIVE
            ]);
        });
    }


    /** create new product
     * @param App\Http\Requests\UpdateProductRequest $productDetails
     * @param App\Models\Product $product
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_product(UpdateProductRequest $productDetails, Product $product) {
        return DB::transaction(function() use ($productDetails, $product) {
            $upload_url = $product->image;

            if($productDetails['image'] != null)
            {
                $upload_url = Cloudinary::uploadApi()->upload($productDetails['image'])['secure_url'];
            }

            return $product->update([
                'type' => ProductTypeEnum::READY_TO_WEAR ?? $product->type,
                'name' => $productDetails['name'] ?? $product->name,
                'image' => $upload_url,
                'description' => $productDetails['description'] ?? $product->description,
                'category_id' => $productDetails['category_id'] ?? $product->category_id,
                'status' => $productDetails['status'] ?? $product->status
            ]);
        });
    }
}