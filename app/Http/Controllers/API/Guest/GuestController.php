<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\{CategoryResource, CategoryTypeResource, DepartmentResource, ProductResource};
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Services\{CategoryService, CategoryTypeService, DepartmentService, ProductService};
use Illuminate\Http\{JsonResponse, Response};

class GuestController extends Controller
{
    public CategoryService $categoryService;
    public DepartmentService $departmentService;
    public CategoryTypeService $categoryTypeService;
    public ProductService $productService;

    public function __construct(
        CategoryService $categoryService, 
        DepartmentService $departmentService,
        CategoryTypeService $categoryTypeService,
        ProductService $productService
    )
    {
        $this->categoryService = $categoryService;
        $this->departmentService = $departmentService;
        $this->categoryTypeService = $categoryTypeService;
        $this->productService = $productService;
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
            'data' => new DepartmentResource($department)
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

    public function products(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($this->productService->get_all_products())
        ]);
    }

    public function product(string $slug): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new ProductResource($this->productService->get_a_single_product($slug))
        ]);
    }

}
