<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->withTrashed()->paginate(10);
        // $posts = Post::all( withTrashed()->paginate(10);
        // return view('posts.index', compact('posts'));
        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        // return view('posts.create', compact('users'));
        return Inertia::render('Posts/Create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }
        Post::create($validatedData);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $post = Post::findOrFail($id);
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);
        $users = User::all();

        // return view('posts.show', compact('post', 'users'));
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
        $users = User::all();


        // return view('posts.edit', compact('post', 'users'));
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        // $post->update($request->validated());
        $validatedData = $request->validated();

        if($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validatedData['image_path'] = $path;
        }
        $post->update($validatedData);



        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        $post->delete();

        return redirect()->route('posts.index');
    }


    public function restore(string $id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('posts.index');
    }
}
