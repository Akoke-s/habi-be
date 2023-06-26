<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreCategoryRequest, UpdateCategoryRequest};
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\{JsonResponse, Response};

class CategoryController extends Controller
{

    public function __construct(
        public CategoryService $categoryService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::select(['name', 'slug', 'cover_image'])->get();;

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'category' => $categories
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryService->create_new_category($request);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => new CategoryResource($category)
            ], Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $category = Category::whereSlug($slug)->select(['name', 'slug', 'cover_image'])->first();

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully',
                'category' => new CategoryResource($category)
            ], Response::HTTP_CREATED);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category = $this->categoryService->update_category($request, $category);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
            ], Response::HTTP_OK);

        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong. Please try again'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
