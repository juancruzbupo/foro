<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class Comment extends Model
{
    protected $fillable = ['comment', 'post_id'];
    
    function post()
    {
      return $this->belongsTo(Post::class);
    }

    function user()
    {
      return $this->belongsTo(User::class);
    }

    function markAsAnswer()
    {
      $this->post->pending = false;
      $this->post->answer_id = $this->id;

      $this->post->save();
    }

    function getAnswerAttribute()
    {
      return $this->id === $this->post->answer_id;
    }

    function getSafeHtmlCommentAttribute()
    {
      return Markdown::convertToHtml(e($this->comment));
    }
}
