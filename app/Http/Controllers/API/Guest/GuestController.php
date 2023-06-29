<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Category;
use App\Models\Department;
use App\Services\{CategoryService, DepartmentService};
use Illuminate\Http\{JsonResponse, Response};

class GuestController extends Controller
{
    public CategoryService $categoryServicce;
    public DepartmentService $departmentService;

    public function __construct(
        CategoryService $categoryService, 
        DepartmentService $departmentService
    )
    {
        $this->categoryServicce = $categoryService;
        $this->departmentService = $departmentService;
    }

    public function getCategories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'categories' => $this->categoryServicce->get_all_categories()
        ], Response::HTTP_OK);
    }

    public function category(Category $category): JsonResponse
    {
        return response()->json([
            'success' => true,
            'categories' => $this->categoryServicce->get_one_category($category)
        ], Response::HTTP_OK);
    }

    public function getDepartments(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'departments' => DepartmentResource::collection($this->departmentService->get_all_departments())
        ], Response::HTTP_OK);
    }

    public function department(Department $department): JsonResponse
    {
        return response()->json([
            'success' => true,
            'categories' => new DepartmentResource($this->departmentService->get_one_department($department))
        ], Response::HTTP_OK);
    }

}
