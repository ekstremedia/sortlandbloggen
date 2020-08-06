<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * Show users posts
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function showPosts()
    {
        // $posts = Post::where('user_id', auth()->user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // return view('post.showposts')
        //     ->with('posts', $posts);
        return view('post.showposts');
    }
    /**
     * Retrieve users posts
     *
     * @return \Illuminate\Http\Response
     */
    public function getPosts()
    {
        $posts = Post::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return $posts;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function postSubmit(Request $request)
    {
        // dd($request->body['title']);

        if (isset($request->body['post_id'])) {
            $thePost = Post::where('id', $request->body['post_id'])->first();
            $thePost->title = $request->body['title'];
            $thePost->post = $request->body['post'];
            $thePost->user_id = auth()->user()->id;
            $thePost->save();
            } else {
            // Making new post
            $thePost = new Post();
            $thePost->title = $request->body['title'];
            $thePost->post = $request->body['post'];
            $thePost->user_id = auth()->user()->id;
            $thePost->save();
        }

        // return response()->json($request);
        $posts = Post::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($posts);
        

        // return redirect('posts');
    }
}
