<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

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
            $postTitle = $request->body['title'];
            $postBody = $request->body['post'];
            $postSlug = Str::slug($postTitle);

            if (isset($request->body['post_id'])) {
                $thePost = Post::where('id', $request->body['post_id'])->first();
            } else {
                // Making new post
                $thePost = new Post();
                $thePost->user_id = auth()->user()->id;
            }

            $thePost->title = $postTitle;
            $thePost->post = $postBody;
            $thePost->slug = $postSlug;
            $thePost->save();
            $response->put("savedPost", $thePost);
            $response->put("postStatus", "success");
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


    public function showPost($id, $slug)
    {
        $post = Post::where('id', $id)
            ->with('author')
            ->first();
        if ($post) {
            return view('post.viewpost')->with('post', $post);
        } else {
            return abort(404);
        }
    }
}
