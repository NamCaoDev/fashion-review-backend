<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userQuery = User::query();
        $users = $userQuery->paginate(10);
        return response()->json($users);
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
    public function store(CreateUserRequest $request)
    {
        //
        User::create($request->all());
        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        if(!$user) {
            return response()->json(["errors"=> "Not found user" ]);
        }
        $userFind = User::showUserDetails($user->id)->get();
        if(!$userFind) {
            return response()->json(["errors"=> "Not found user" ]);
        }
        return response()->json($userFind);
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
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $user->update($request->all());
        return response()->json(["success"=> true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json(["success"=> true]);
    }
}
