<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryTypeRequest;
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

}