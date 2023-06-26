<?php 

namespace App\Services;

use App\Enums\GenderEnum;
use App\Models\Category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\{StoreCategoryRequest, UpdateCategoryRequest};

class CategoryService {

    /** get men categories
     * 
    */

    public function menCategories() {
        return Category::ofGender(GenderEnum::MEN)->get();
    }

    /** get women categories
     * 
    */

    public function womenCategories() {
        return Category::ofGender(GenderEnum::WOMEN)->get();
    }

    /** get boys categories
     * 
    */

    public function boysCategories() {
        return Category::ofGender(GenderEnum::KIDS[0])->get();
    }

    /** get girls categories
     * 
    */

    public function girlsCategories() {
        return Category::ofGender(GenderEnum::KIDS[1])->get();
    }

    /** create new category
     * @param App\Http\Requests\StoreCategoryRequest $categoryDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_new_category(StoreCategoryRequest $categoryDetails)
    {
        
        return DB::transaction(function() use ($categoryDetails) {
            $upload_url = Cloudinary::uploadApi()->upload($categoryDetails['cover_image'])['secure_url'];

            return Category::create([
                'name' => $categoryDetails['name'],
                'cover_image' => $upload_url
            ]);
        });
    }

    /** update category
     * @param App\Http\Requests\UpdateCategoryRequest $categoryDetails
     * @param App\Models\Category $category
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function update_category(UpdateCategoryRequest $categoryDetails, Category $category)
    {
        
        return DB::transaction(function() use ($categoryDetails, $category) {
            $upload_url = $category->cover_image;

            if($categoryDetails['cover_image'] != null) {
                $upload_url = Cloudinary::uploadApi()->upload($categoryDetails['cover_image'])['secure_url'];
            }

            return $category->update([
                'name' => $categoryDetails['name'] ?? $category->name,
                'gender' => $categoryDetails['gender'] ?? $category->gender,
                'cover_image' => $upload_url
            ]);
        });
    }
}