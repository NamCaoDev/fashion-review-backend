<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Permission::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        return $this->sendResponse(PermissionResource::collection($permissions), 'Permission retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Permission $Permission)
    {
        //
        return $this->sendResponse(new PermissionResource($Permission), 'Permission retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
}
