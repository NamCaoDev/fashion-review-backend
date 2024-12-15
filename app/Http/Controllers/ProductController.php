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

    public function index()
    {
        //
        $productQuery = Product::query();
        $products = $productQuery->with('brand')->paginate(perPage: 10);
        return $this->sendResponse(ProductResource::collection($products), 'Product retrieved successfully.');
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
