<?php

namespace App;

use App\Notifications\PostCommented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Notification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
      return $this->hasMany(Post::class);
    }

    function createPost(array $data)
    {
      $post = new Post($data);

      $this->posts()->save($post);

      $this->subscribeTo($post);

      return $post;
    }

    function comments()
    {
      return $this->hasMany(Comment::class);
    }

    function subscriptions()
    {
      return $this->belongsToMany(Post::class, 'subscriptions');
    }

    function comment(Post $post, $message)
    {
      $comment = new Comment([
        'comment' => $message,
        'post_id' => $post->id,
      ]);

      $this->comments()->save($comment);

      //Notify subscriber
      Notification::send(
        $post->subscribers()->where('user_id', '!=', $this->id)->get(),
        new PostCommented($comment)
      );

      return $comment;

    }

    function isSubscribedTo(Post $post)
    {
      return $this->subscriptions()->where('post_id', $post->id)->count() > 0;
    }

    function subscribeTo(Post $post)
    {
      $this->subscriptions()->attach($post);
    }

    function unSubscribeFrom(Post $post)
    {
      $this->subscriptions()->detach($post);
    }

    function owns(Model $model)
    {
      return $this->id === $model->user_id;
    }

}
