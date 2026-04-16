<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Post $post)
    {
        // $request->validate([
        //     'body' => 'required|min:3',
        //     // 'user_id' => 'required|exists:users,id',
        // ]);

        $post->comments()->create([
            'body' => $request->validated('body'),
            // 'user_id' => $request->user_id,
            'user_id' => auth()->id(),
        ]);

        return back();
    }

}
