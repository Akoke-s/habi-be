<?php

namespace App\Services;

use App\Models\Department;
use App\Http\Requests\{StoreDepartmentRequest, UpdateDepartmentRequest};
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

    /** update a department
     * @param App\Http\Requests\UpdateDepartmentRequest $departmentDetails
     * @param App\Models\Department $department
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function update_department(UpdateDepartmentRequest $departmentDetails, Department $department) 
    {
        return DB::transaction(function() use ($departmentDetails, $department) {
            
            return $department->update([
                'name' => $departmentDetails['name'] ?? $department->name,
                'category_id' => $departmentDetails['category_id'] ?? $department->category_id
            ]);
        });
    }
}