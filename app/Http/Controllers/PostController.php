<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = $this->getPosts();
        // $posts = Post::all();
        $posts = Post::withTrashed()->paginate(10);


        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // validate the request data
        

        // create a new post instance and save it to the database
        // $post = new Post();
        // $post->title = $request->title;
        // $post->body = $request->body;
        // $post->save();
        Post::create($request->validated());

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $posts = $this->getPosts();

        // $post = $posts[$id] ?? [
        //     'id' => $id,
        //     'title' => 'Post Not Found',
        //     'body' => 'This post was not found in the static array.'
        // ];
        // $post = Post::find($id);
        $post = Post::findOrFail($id);


        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $posts = $this->getPosts();

        // $post = $posts[$id] ?? [
        //     'id' => $id,
        //     'title' => 'Post Not Found',
        //     'body' => 'This post was not found in the static array.'
        // ];
        // $post = Post::find($id);
        $post = Post::findOrFail($id);
        $users = User::all();


        return view('posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $id)
    {
        // $post = Post::find($id);
        // $post->title = $request->input('title');
        // $post->body = $request->input('body');
        // $post->save();

        $post = Post::findOrFail($id);
        $post->update($request->validated());


        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $post = Post::find($id);
        // $post->delete();
        $post = Post::findOrFail($id);
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
