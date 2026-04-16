<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 4. Validation: Validate the incoming API payload before storing.
        // Because this is an API route, if validation fails, Laravel automatically
        // returns a 422 JSON response with the error messages.
        $validatedData = $request->validate([
            'title' => 'required|min:3|unique:posts,title',
            'body' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Securely assign the user ID using the Sanctum token
        $validatedData['user_id'] = auth()->id();

        // Handle optional image upload (works exactly like the web controller)
        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validatedData);

        // Return the new post wrapped in the resource (load the user so the nested UserResource works)
        return new PostResource($post->load('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
