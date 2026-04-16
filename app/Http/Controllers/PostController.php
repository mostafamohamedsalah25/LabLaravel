<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->withTrashed()->paginate(10);
        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $users = User::all();
        // return Inertia::render('Posts/Create', [
        //     'users' => $users
        // ]);
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = auth()->id();

        $this->handleImageUpload($request, $validatedData);
        // if($request->hasFile('image')) {
        //     $path = $request->file('image')->store('posts', 'public');
        //     $validatedData['image_path'] = $path;
        // }
        Post::create($validatedData);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);
        $users = User::all();
        return Inertia::render('Posts/Show', [
            'post' => $post,
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        Gate::authorize('update', $post);
        // $users = User::all();

        return Inertia::render('Posts/Edit', [
            'post' => $post,
            // 'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        Gate::authorize('update', $post);
        $validatedData = $request->validated();

        $this->handleImageUpload($request, $validatedData, $post->image_path);
        // if($request->hasFile('image')) {
        //     if ($post->image_path) {
        //         Storage::disk('public')->delete($post->image_path);
        //     }
        //     $path = $request->file('image')->store('posts', 'public');
        //     $validatedData['image_path'] = $path;
        // }
        $post->update($validatedData);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        Gate::authorize('delete', $post);
        // if ($post->image_path) {
        //     Storage::disk('public')->delete($post->image_path);
        // }
        $post->delete();

        return redirect()->route('posts.index');
    }


    public function restore(string $id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        Gate::authorize('restore', $post);
        $post->restore();
        return redirect()->route('posts.index');
    }

    private function handleImageUpload($request, array &$validatedData, $existingImagePath = null)
    {
        if ($request->hasFile('image')) {
            if ($existingImagePath) {
                disk('public')->delete($existingImagePath);
            }

            $validatedData['image_path'] = $request->file('image')->store('posts', 'public');
        }
    }

}

