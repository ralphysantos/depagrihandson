<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'post_id' => 'required',
            'content' => 'required'
        ]);

        $post = auth()->user()->posts()->find($request->post_id);

        if(!$post){
            return response()->json([
                'message' => 'Post not found'
            ],404);
        }

        $post->comments()->create($request->all());

        return response()->json([
            'comment' => $comment
        ],201);
    }

    public function update(Request $request, $id){
        $comment = auth()->user()->comments()->find($id);

        if(!$comment){
            return response()->json([
                'message' => 'Comment not found'
            ],404);
        }

        $comment->update($request->all());

        return response()->json([
            'comment' => $comment
        ],200);
    }

    public function delete($id){
        $comment = auth()->user()->comments()->find($id);

        if(!$comment){
            return response()->json([
                'message' => 'Comment not found'
            ],404);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ],200);
    }
}
