<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class CreatePostsController extends Controller
{
    public function create()
    {
      return view('posts.create');
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'title'   => 'required',
        'content' => 'required',
      ]);

      $post = auth()->user()->createPost($request->all());

      return redirect($post->url);
    }
}
