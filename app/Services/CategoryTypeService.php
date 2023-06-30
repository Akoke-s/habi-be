<?php

namespace App\Services;

use App\Http\Requests\{StoreCategoryTypeRequest, UpdateCategoryTypeRequest};
use App\Models\CategoryType;
use Illuminate\Support\Facades\DB;

class CategoryTypeService {

    /**
     * get all category types
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function get_category_types() {
        return CategoryType::select(['id', 'name', 'department_id'])->get();
    }

    /**
     * get a single category type
     * @param string $slug
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function get_category_type(string $slug)
    {
        return CategoryType::whereSlug($slug)->select(['id', 'name', 'department_id'])->first();
    }

    /**
     * create a new category type
     * @param App\Http\Requests\StoreCategoryTypeRequest $typeDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function create_category_type(StoreCategoryTypeRequest $typeDetails)
    {
        return DB::transaction(function () use ($typeDetails) {
            return CategoryType::create([
                'name' => $typeDetails['name'],
                'department_id' => $typeDetails['department_id'],
            ]);
        });
    }

     /** update a department
     * @param App\Http\Requests\UpdateCategoryTypeRequest $typeDetails
     * @param string $slug
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function update_category_type(UpdateCategoryTypeRequest $typeDetails, string $slug)
    {
        return DB::transaction(function () use ($typeDetails, $slug) {
            $type = CategoryType::whereSlug($slug)->first();
            return $type->update([
                'name' => $typeDetails['name'] ?? $type->name,
                'department_id' => $typeDetails['department_id'] ?? $type->department_id,
            ]);
        });
    }

}