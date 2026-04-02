<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    private function getPosts()
    {
        return [
            1 => ['id' => 1, 'title' => 'First Post', 'body' => 'This is the content of the first post.'],
            2 => ['id' => 2, 'title' => 'Second Post', 'body' => 'This is the content of the second post.'],
            3 => ['id' => 3, 'title' => 'Third Post', 'body' => 'This is the content of the third post.']
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = $this->getPosts();
        $posts = Post::all();


        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        // create a new post instance and save it to the database
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

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
        $post = Post::find($id);


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
        $post = Post::find($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();


        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        

        return redirect()->route('posts.index');
    }
}
