<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
        $this->authorizeResource(Brand::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $queryParams = $request->query();
        $limit = config('app.pagination.limit');
        $page = config('app.pagination.page');
        $brandQuery = Brand::query();
        if(isset($queryParams['limit'])) {
            $limit = (int)$queryParams['limit'];
        }
        if(isset($queryParams['page'])) {
            $page = (int)$queryParams['page'];
        }
        if(isset($queryParams['type'])) {
            $brandQuery->findBrandByType(explode('.',$queryParams['type']));
        }
        if(isset($queryParams['name'])) {
            $brandQuery->findBrandByName($queryParams['name']);
        }
        if(isset($queryParams['founder'])) {
            $brandQuery->findBrandByFounder($queryParams['founder']);
        }
        $brandCount = $brandQuery->count();

        $brands = $brandQuery->latest()->paginate($limit);
        return $this->sendResponse( ["records" => BrandResource::collection($brands), "total_records" => $brandCount, "current_page" => $page], 'Brand retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBrandRequest $request)
    {
        //
        $brand = Brand::create($request->all());
        return $this->sendResponse(new BrandResource($brand), 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
        return $this->sendResponse(new BrandResource($brand), 'Brand retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request,  Brand $brand)
    {
        //
        $brand->update($request->all());
        return $this->sendResponse(null, 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
        $brand->products()->delete();
        $brand->delete();
        return $this->sendResponse(null, 'Brand deleted successfully.');
    }
}
