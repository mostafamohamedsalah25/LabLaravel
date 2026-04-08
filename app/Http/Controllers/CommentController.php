<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:3',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->comments()->create([
            'body' => $request->body,
            'user_id' => $request->user_id,
        ]);

        return back();
    }

}
