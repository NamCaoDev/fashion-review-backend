<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        //
        $queryParams = $request->query();
        $limit = 20;
        $page = 1;
        $userQuery = User::query();
        if(isset($queryParams['limit'])) {
            $limit = (int)$queryParams['limit'];
        }
        if(isset($queryParams['page'])) {
            $page = (int)$queryParams['page'];
        }
        if(isset($queryParams['role'])) {
            $userQuery->findUserByRole(explode('.',$queryParams['role']));
        }
        if(isset($queryParams['username'])) {
            $userQuery->findUserByUsername($queryParams['username']);
        }
        if(isset($queryParams['name'])) {
            $userQuery->findUserByName($queryParams['name']);
        }
        if(isset($queryParams['email'])) {
            $userQuery->findUserByEmail($queryParams['email']);
        }
        if(isset($queryParams['is_banned'])) {
            $arr_cond = [];
            if(str_contains($queryParams['is_banned'], 'banned')) {
                array_push($arr_cond, true);
            }
            if(str_contains($queryParams['is_banned'], 'no-banned')) {
                array_push($arr_cond, false);
            }
            $userQuery->findUserBanned($arr_cond);
        }
        $userCount = $userQuery->count();
        $users = $userQuery->with('permissions')->with('posts')->latest()->paginate($limit);
        return $this->sendResponse( ["records" => UserResource::collection($users), "total_records" => $userCount, "current_page" => $page], 'User retrieved successfully.');
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
