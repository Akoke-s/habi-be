<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryTypeRequest;
use App\Http\Resources\CategoryTypeResource;
use App\Models\CategoryType;
use App\Services\CategoryTypeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{JsonResponse, Request, Response};

class CategoryTypeController extends Controller
{
    public CategoryTypeService $categoryService;

    public function __construct(CategoryTypeService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $types = $this->categoryService->get_category_types();

        return response()->json([
            'success' => true,
            'message' => 'Category types retrieved successfully',
            'data' => CategoryTypeResource::collection($types)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryTypeRequest $request)
    {        
        try {
            $type = $this->categoryService->create_category_type($request);
            return response()->json([
                'success' => true,
                'message' => 'Category type created successfully',
                'data' => new CategoryTypeResource($type)
            ], Response::HTTP_CREATED);
        } catch (\Throowable $e) {
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
    public function show(string $slug): JsonResponse
    {
        $type = CategoryType::whereSlug($slug)->select(['id', 'name', 'slug' , 'department_id'])->first();
        
        if(!$type) {
            throw new ModelNotFoundException();
        }

        return response()->json([
            'success' => true,
            'message' =>'Category type retrieved successfully',
            'data' => new CategoryTypeResource($type)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
