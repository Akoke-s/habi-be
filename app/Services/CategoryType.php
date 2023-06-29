<?php

namespace App\Services;
use App\Models\CategoryType as Type;

class CategoryType {

    /**
     * get all category types
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function get_category_types() {
        return Type::select(['id', 'name', 'department_id'])->get();
    }
}