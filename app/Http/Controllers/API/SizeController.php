<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreSizeRequest, UpdateSizeRequest};
use App\Http\Resources\SizeResource;
use App\Models\{Color, Size};
use App\Services\SizeService;
use Illuminate\Http\{JsonResponse, Response};

class SizeController extends Controller
{
    public function __construct(
        public SizeService $sizeService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index(Color $color)
    {
        try {
            return response()->json([
                'success' => true,
                'sizes' => $color->sizes
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
    public function store(StoreSizeRequest $request, Color $color): JsonResponse
    {
        try {
            $size = $this->sizeService->create_new_size($request, $color);
            return response()->json([
                'success' => true,
                'color' => new SizeResource($size)
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
    public function show(Size $size)
    {
        try {

            return response()->json([
                'success' => true,
                'size' => new SizeResource($size)
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
    public function update(UpdateSizeRequest $request, Size $size)
    {
        try {
            $updated_size = $this->sizeService->update_size($request, $size);
            return response()->json([
                'success' => $updated_size,
                'message' => 'Updated size successfully'
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
