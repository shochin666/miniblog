<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Post\CreatePostRequest;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user'])->orderBy('created_at', 'desc')->get();
    
        return view('index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $post = new Post; //データベースと接続
        $post->fill($request->all());
        $post->user()->associate(Auth::user()); 
        $post->save();

        return redirect()->to('/');
    }

    public function delete(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();
    
        return redirect()->to('/');
    }

    public function show(Post $post)
    {
        $post->load('replies.user');

        return view('posts.show', ['post' => $post]);
    }

    public function reply(Request $request, Post $post)
    {
        $reply = new Reply;
        $reply->fill($request->all());
        $reply->user()->associate(Auth::user());
        $reply->post()->associate($post);
        $reply->save();

        return redirect()->back();
    }


}