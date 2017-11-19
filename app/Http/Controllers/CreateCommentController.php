<?php

namespace App\Http\Controllers;

use App\{Post, Comment};
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

    function accept(Comment $comment)
    {
      //utilizando politica de acceso 
      $this->authorize('accept', $comment);

      $comment->markAsAnswer();

      return redirect($comment->post->url);
    }
}
