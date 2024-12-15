<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
        $this->authorizeResource(Post::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $postQuery = Post::query();
        $posts = $postQuery->with('user')->paginate(perPage: 10);
        return $this->sendResponse(PostResource::collection($posts), 'Post retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        //
        $request['user_id'] = Auth::user()->id;
        $post = Post::create($request->all());
        return $this->sendResponse(new PostResource($post), 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
        $post->update($request->all());
        return $this->sendResponse(null, 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->user()->detach($post->id);
        $post->product()->detach($post->id);
        $post->delete();
        return $this->sendResponse(null, 'Post deleted successfully.');
    }
}
