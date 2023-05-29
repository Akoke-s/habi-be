<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreColorRequest, UpdateColorRequest};
use App\Http\Resources\ColorResource;
use App\Models\{Color, Product};
use App\Services\ColorService;
use Illuminate\Http\{JsonResponse, Response};
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function __construct(
        public ColorService $colorService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'colors' => $product->colors
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
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request, Product $product): JsonResponse
    {
        try {
            $color = $this->colorService->create_new_color($request, $product);
            return response()->json([
                'success' => true,
                'color' => new ColorResource($color)
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
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        try {

            return response()->json([
                'success' => true,
                'color' => new ColorResource($color)
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
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        try {
            $color = $this->colorService->update_color($request, $color);
            return response()->json([
                'success' => $color,
                'message' => 'Updated color successfully'
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
