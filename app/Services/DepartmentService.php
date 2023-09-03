<?php

namespace App\Services;

use App\Models\Department;
use App\Http\Requests\{StoreDepartmentRequest, UpdateDepartmentRequest};
use Illuminate\Support\Facades\DB;

class DepartmentService {

    /**
     * get all departments
    */
    public function get_all_departments() {
        return Department::select(['id', 'name', 'slug', 'category_id'])->get();
    }

    /** create new department
     * @param App\Http\Requests\StoreDepartmentRequest $departmentDetails
     * @return \Illuminate\Auth\Access\Response|bool
    */

    /**
     * get one department
     * @param App\Models\Department $department
     * * @return \Illuminate\Auth\Access\Response|bool
    */
    public function get_one_department(Department $department) {
        return $department->select(['id', 'name', 'slug', 'category_id'])->first();
    }

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