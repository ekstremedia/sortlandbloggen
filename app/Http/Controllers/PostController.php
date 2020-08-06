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
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        return $posts;
    }

    public function postSubmit(Request $request)
    {
        // // dd($request->body['title']);
        $response = collect();

        $error = [];

        if (!isset($request->body['title']) || empty($request->body['title'])) {
            $error[] = "Empty title";
        }
        if (!isset($request->body['post']) || empty($request->body['post'])) {
            $error[] = "Empty post";
        }

        if (!$error) {
            if (isset($request->body['post_id'])) {
                $thePost = Post::where('id', $request->body['post_id'])->first();
                $thePost->title = $request->body['title'];
                $thePost->post = $request->body['post'];
                $thePost->user_id = auth()->user()->id;
                $thePost->save();
                $response->put("savedPost", $thePost);
                $response->put("postStatus", "success");
            } else {
                // Making new post
                $thePost = new Post();
                $thePost->title = $request->body['title'];
                $thePost->post = $request->body['post'];
                $thePost->user_id = auth()->user()->id;
                $thePost->save();
                $response->put("savedPost", $thePost);
                $response->put("postStatus", "success");
            }
        } else {
            $response->put("error", $error);
        }
        $posts = Post::where('user_id', auth()->user()->id)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        $response->put("allPosts", $posts);

        return response()->json($response);
    }

    public function deletePost(Request $request)
    {
        // // dd($request->body['title']);
        $response = collect();
        $errors = [];
        $thePost = Post::where('id', $request->body['id'])->first();
        if ($thePost) {
            if ($thePost->delete()) {
                $response->put("deleteStatus", "success");
            } else {
                $response->put("deleteStatus", "error");
                $errors[] = "Could not delete the post";
            }
        } else {
            $response->put("deleteStatus", "error");
            $errors[] = "The post does not exist.";
        }
        $posts = Post::where('user_id', auth()->user()->id)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        $response->put("allPosts", $posts);
        $response->put("deletedPost", $thePost);
        if ($errors) {
            $response->put("errors", $errors);
        }

        return response()->json($response);
    }


    public function test()
    {
        // $c = collect();
        // $okObj = "OK";
        // $post = Post::where('id', 3)->first();
        // $c->add($okObj);
        // $c->add($post);
        // return response()->json($c);

        $post = Post::where('id', 1)
            ->with('author')
            ->first();

        return $post;
    }
}
