<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreDepartmentRequest, UpdateDepartmentRequest};
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{JsonResponse, Response};

class DepartmentController extends Controller
{

    public DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $departments = Department::select(['name', 'slug', 'category_id'])->get();
            return response()->json([
                'success' => true,
                'message' => 'Departments retrieved successfully',
                'departments' => DepartmentResource::collection($departments)
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
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->create_new_department($request);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'department' => new DepartmentResource($department)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $department = Department::whereSlug($slug)->select(['name', 'slug', 'category_id'])->first();
        if(!$department) {
            throw new ModelNotFoundException();
        }
        return response()->json([
            'success' => true,
            'message' => 'Department retrieved successfully',
            'department' => new DepartmentResource($department)
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $slug): JsonResponse
    {
        $department = Department::whereSlug($slug)->first();
        
        $this->departmentService->update_department($request, $department);

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully',
            'department' => new DepartmentResource($department)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug): JsonResponse
    {
        $department = Department::whereSlug($slug)->first();
            if(count($department->category_types) > 0) {
                foreach($department->category_types as $type) {
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
                    $type->delete();
                }
            }
            
            $delete = $department->delete();
            return response()->json([
                'success' => $delete,
                'message' => 'Department deleted successfully',
            ], Response::HTTP_OK);
    }
    
}
