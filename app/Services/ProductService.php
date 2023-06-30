<?php 

namespace App\Services;

use App\Enums\GenericStatusEnum;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\{StoreProductRequest, UpdateProductRequest};
use App\Models\Product;

class ProductService {

    /**
     * get all products
    */
    public function get_all_products() {
        return Product::select(['name', 'slug', 'description', 'material', 'status', 'category_type_id'])->get();
    }

    /**
     * get all products
     * @param string $slug
    */
    public function get_a_single_product(string $slug) {
        return Product::whereSlug($slug)->select(['name', 'slug', 'description', 'material', 'status', 'category_type_id'])->first();
    }
    /** create new product
     * @param App\Http\Requests\StoreProductRequest $productDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_new_product(StoreProductRequest $productDetails) {
        return DB::transaction(function() use ($productDetails) {
            
            $upload_url = Cloudinary::uploadApi()->upload($productDetails['image'])['secure_url'];

            return Product::create([
                'name' => $productDetails['name'],
                'image' => $upload_url,
                'description' => $productDetails['description'],
                'material' => $productDetails['material'],
                'category_type_id' => $productDetails['category_type_id'],
                'status' => GenericStatusEnum::INACTIVE
            ]);
        });
    }


    /** create new product
     * @param App\Http\Requests\UpdateProductRequest $productDetails
     * @param string $slug
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_product(UpdateProductRequest $productDetails, string $slug) {
        return DB::transaction(function() use ($productDetails, $slug) {
            $product = Product::whereSlug($slug)->first();

            $upload_url = $product->image;

            if($productDetails['image'] != null)
            {
                $upload_url = Cloudinary::uploadApi()->upload($productDetails['image'])['secure_url'];
            }

            return $product->update([
                'name' => $productDetails['name'] ?? $product->name,
                'image' => $upload_url,
                'description' => $productDetails['description'] ?? $product->description,
                'category_type_id' => $productDetails['category_type_id'] ?? $product->category_type_id,
                'status' => $productDetails['status'] ?? $product->status,
                'material' => $productDetails['material'] ?? $product->material
            ]);
        });
    }
}