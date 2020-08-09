<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function showPosts()
    {
        return view('post.showposts');
    }

    public function getPosts()
    {
        // Retrieve all posts made by current user logged in
        $posts = Post::where('user_id', auth()->user()->id)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        return $posts;
    }

    public function getPost($id)
    {
        // Retrieve post based on post id
        $post = Post::where('id', $id)
            ->with('author')
            ->first();
        return $post;
    }

    public function postSubmit(Request $request)
    {
        // Initiate $response collect instance and $error array
        $response = collect();
        $error = [];

        // Validate user and post, add errors to $errors array if found.
        if (auth()->user()->read_only) {
            $error[] = "You have no write access";
        }
        // Check for empty posts, if you add posts with spaces it goes trough boostrap validator
        // even though post really is empty.
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

            // Post is now saved, then add it to the $response instance
            $response->put("savedPost", $thePost);
            $response->put("postStatus", "success");
        } else {
            // Errors are found, add them to the $response instance
            $response->put("error", $error);
        }
        // Add all users posts to the $esponse instance
        $posts = Post::where('user_id', auth()->user()->id)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();
        $response->put("allPosts", $posts);
        // Return the $response instance as json
        return response()->json($response);
    }

    public function deletePost(Request $request)
    {
        // Initiate $response collect instance and errors array
        $errors = [];
        $response = collect();

        if (auth()->user()->read_only) {
            // User is read only, and can therefore not delete post even if he tried to send a post request
            $errors[] = "You have no write access";
            $response->put("deleteStatus", "noaccess");
        } else {
            $thePost = Post::where('id', $request->body['id'])->first();
            if ($thePost) {
                if ($thePost->delete()) {
                    // If post successfully deleted, add it to the $response collection
                    $response->put("deleteStatus", "success");
                } else {
                    // If post delete failed, add error to the $response collection
                    $response->put("deleteStatus", "error");
                    $errors[] = "Could not delete the post";
                }
            } else {
                // If post not found, add to error array. 
                // Note that this still sends $posts object further down, so list gets updated and deleted post will disappear.
                // In cases where one might delete a post in another tab or so. 
                $response->put("deleteStatus", "error");
                $errors[] = "The post does not exist.";
            }
            // Add all posts to collection to update posts page with all changes.
            $posts = Post::where('user_id', auth()->user()->id)
                ->with('author')
                ->orderBy('created_at', 'desc')
                ->get();
            $response->put("allPosts", $posts);
            // Add info about deleted post to show in notifications
            $response->put("deletedPost", $thePost);
        }
        if ($errors) {
            // Add errors to the $repsonse collection if any 
            $response->put("errors", $errors);
        }
        // Return the $response instance as json
        return response()->json($response);
    }

    public function showPost($id, $slug)
    {
        // Try to find post based on post id and slug
        $post = Post::where('id', $id)
            ->where('slug', $slug)
            ->with('author')
            ->first();
        if ($post) {
            return view('post.viewpost')->with('post', $post);
        } else {
            // Display 404 if post is not found
            return response()->view('layouts.404', [], 404);
        }
    }

    public function paginationResults()
    {
        // Return all posts with pagination
        $posts = Post::orderBy('created_at', 'desc')
            ->with('author')
            ->paginate(3);
        return  $posts;
    }
}
