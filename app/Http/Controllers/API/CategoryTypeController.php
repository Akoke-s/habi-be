<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryTypeResource;
use App\Services\CategoryType;
use Illuminate\Http\{JsonResponse, Request, Response};

class CategoryTypeController extends Controller
{
    public CategoryType $categoryService;

    public function __construct(CategoryType $categoryService)
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
