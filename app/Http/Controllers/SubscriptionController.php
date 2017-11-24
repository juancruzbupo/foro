<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    function subscribe(Post $post)
    {
      auth()->user()->subscribeTo($post);

      return redirect($post->url);
    }

    function unsubscribe(Post $post)
    {
      auth()->user()->unSubscribeFrom($post);

      return redirect($post->url);
    }
}
