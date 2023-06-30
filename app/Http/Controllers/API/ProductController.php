<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreProductRequest, UpdateProductRequest};
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\{JsonResponse, Response};

class ProductController extends Controller
{

    public function __construct(
        public ProductService $productService
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::select([
                'id',
                'name',
                'image',
                'description',
                'slug',
                'category_type_id',
            ])->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => ProductResource::collection($products)
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
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $product = $this->productService->create_new_product($request);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => new ProductResource($product)
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
            $product = Product::whereSlug($slug)->select([
                'id', 
                'name', 
                'status',
                'slug',
                'description',
                'material',
                'category_type_id'
            ])->first();
            return response()->json([
                'success' => true,
                'data' => new ProductResource($product)
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $slug)
    {
        
        $response = $this->productService->update_product($request, $slug);

        return response()->json([
            'success' => true,
            'message' =>$response ? 'Product updated successfully' : 'Product could not be updated',
        ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::whereSlug($slug)->select(['id'])->first();
        $colors = $product->colors;
        if(count($colors) > 0) {
            foreach($colors as $color) {
                if(count($color->sizes) > 0) {
                    foreach($color->sizes as $size) {
                        $size->delete();
                    }
                }
                
                $color->delete();
            }
        }

        $delete = $product->delete();

        return response()->json([
            'success' => $delete,
            'message' => $delete ? 'Product deleted successfully' : 'Product could not be deleted'
        ], $delete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
