<?php

namespace App\Http\Controllers\API\Guest;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\{JsonResponse, Response};

class GuestController extends Controller
{
    public CategoryService $categoryServicce;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServicce = $categoryService;
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

}
