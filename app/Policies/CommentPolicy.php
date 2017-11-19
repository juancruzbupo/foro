<?php

namespace App\Policies;

use App\{User, Comment};
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    function accept(User $user, Comment $comment)
    {
      //si un usuario es propietario de un post
      return $user->owns($comment->post);
    }

}
