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
}