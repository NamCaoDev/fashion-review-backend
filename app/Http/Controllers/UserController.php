<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
        $this->middleware('role:admin')->only(['store', 'destroy']);
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userQuery = User::query();
        $users = $userQuery->with('permissions')->with('posts')->paginate(10);
        return $this->sendResponse( UserResource::collection($users), 'User retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        //
        $user = User::create($request->all());
        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $user->update($request->all());
        return $this->sendResponse(null, 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->posts()->delete();
        $user->delete();
        return $this->sendResponse(null, 'User deleted successfully.');
    }
}
