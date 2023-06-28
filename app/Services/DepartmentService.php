<?php

namespace App\Services;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Support\Facades\DB;

class DepartmentService {

    /** create new department
     * @param App\Http\Requests\StoreDepartmentRequest $departmentDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function create_new_department(StoreDepartmentRequest $departmentDetails) 
    {
        return DB::transaction(function() use ($departmentDetails) {
            return Department::create([
                'name' => $departmentDetails['name'],
                'category_id' => $departmentDetails['category_id']
            ]);
        });
    }
}