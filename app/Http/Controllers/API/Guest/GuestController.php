<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\{CategoryResource, CategoryTypeResource, DepartmentResource};
use App\Models\Category;
use App\Models\Department;
use App\Services\{CategoryService, CategoryTypeService, DepartmentService};
use Illuminate\Http\{JsonResponse, Response};

class GuestController extends Controller
{
    public CategoryService $categoryService;
    public DepartmentService $departmentService;
    public CategoryTypeService $categoryTypeService;

    public function __construct(
        CategoryService $categoryService, 
        DepartmentService $departmentService,
        CategoryTypeService $categoryTypeService

    )
    {
        $this->categoryService = $categoryService;
        $this->departmentService = $departmentService;
        $this->categoryTypeService = $categoryTypeService;
    }

    public function getCategories(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($this->categoryService->get_all_categories())
        ], Response::HTTP_OK);
    }

    public function category(Category $category): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' =>  new CategoryResource($this->categoryService->get_one_category($category))
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
            'data' => new DepartmentResource($this->departmentService->get_one_department($department))
        ], Response::HTTP_OK);
    }

    public function getTypes(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => CategoryTypeResource::collection($this->categoryTypeService->get_category_types())
        ]);
    }

    public function type(string $slug): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CategoryTypeResource($this->categoryTypeService->get_category_type($slug))
        ]);
    }

}
