<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
  function index()
  {
    $posts = Post::orderBy('created_at', 'DESC')->paginate();

    return view('posts.index', compact('posts'));
  }

  function show(Post $post, $slug)
  {
    if($post->slug != $slug) {
      return redirect($post->url, 301);
    }

    return view('posts.show', compact('post'));
  }

}
