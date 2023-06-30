<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreCategoryTypeRequest, UpdateCategoryTypeRequest};
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
    public function update(UpdateCategoryTypeRequest $request, string $slug)
    {
        $response = $this->categoryService->update_category_type($request, $slug);

        return response()->json([
            'success' => $response,
            'message' => $response ? 'Category Type updated successfully' : 'An error occurred while updating type',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $type = CategoryType::whereSlug($slug)->select(['id'])->first();

        if(!$type) {
            throw new ModelNotFoundException();
        }

        if(count($type->products) > 0) {
            foreach($type->products as $product) {
                if(count($product->colors) > 0) {
                    foreach($product->colors as $color) {
                        if(count($color->sizes) > 0) {
                            foreach($color->sizes as $size) {
                                $size->delete();
                            }
                        }
                        $color->delete();
                    }
                }
                $product->delete();
            }
        }

        $deleted = $type->delete();

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'Deleted type successfully' : 'Unable to delete type'
        ], Response::HTTP_OK);
    }
}
