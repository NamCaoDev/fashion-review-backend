<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;

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
    public function index()
    {
        //
        $brandQuery = Brand::query();
        $brands = $brandQuery->paginate(perPage: 10);
        return $this->sendResponse(BrandResource::collection($brands), 'Brand retrieved successfully.');
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
