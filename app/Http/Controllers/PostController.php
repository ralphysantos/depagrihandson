<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    
    public function create(Request $request){
        $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = auth()->user()->posts()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body
        ]);

        return response()->json([
            'post' => $post
        ],201);
    }

    public function update(Request $request, $id){
        $post = auth()->user()->posts()->find($id);

        if(!$post){
            return response()->json([
                'message' => 'Post not found'
            ],404);
        }

        $post->update($request->all());

        return response()->json([
            'post' => $post
        ],200);
    }

    public function delete($id){
        $post = auth()->user()->posts()->find($id);

        if(!$post){
            return response()->json([
                'message' => 'Post not found'
            ],404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ],200);
    }

    public function view(){
        $posts = Post::with('comments')->all();

        return response()->json([
            'posts' => $posts
        ],200);
    }
}
