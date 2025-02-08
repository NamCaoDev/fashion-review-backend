<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
        $this->authorizeResource(Product::class);
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
        $productQuery = Product::query()->with('brand');
        if(isset($queryParams['limit'])) {
            $limit = (int)$queryParams['limit'];
        }
        if(isset($queryParams['page'])) {
            $page = (int)$queryParams['page'];
        }
        if(isset($queryParams['product_type'])) {
            $productQuery->findProductByType(explode('.',$queryParams['product_type']));
        }
        if(isset($queryParams['name'])) {
            $productQuery->findProductByName($queryParams['name']);
        }
        if(isset($queryParams['brand_id'])) {
            $productQuery->findProductByBrandId($queryParams['brand_id']);
        }
        $productCount = $productQuery->count();
        $products = $productQuery->latest()->paginate($limit);
        return $this->sendResponse( ["records" => ProductResource::collection($products), "total_records" => $productCount, "current_page" => $page], 'Product retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        //
        $post = Product::create($request->all());
        return $this->sendResponse(new ProductResource($post), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Product $product)
    {
        //
        $product->update($request->all());
        return $this->sendResponse(null, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product->posts()->delete();
        $product->delete();
        return $this->sendResponse(null, 'Product deleted successfully.');
    }
}
