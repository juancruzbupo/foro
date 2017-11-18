<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class CreateCommentController extends Controller
{
    function store(Request $request, Post $post) //utilizando implicit model binding
    {
      $this->validate($request, [
        'comment' => 'required',
      ]);

      auth()->user()->comment($post, $request->get('comment'));

      return redirect($post->url);
    }
}
