<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    //obliga al tipo de dato q sea el dato
    protected $casts = [
      'pending' => 'boolean',
    ];

    function user()
    {
      return $this->belongsTo(User::class);
    }

    function comments()
    {
      return $this->hasMany(Comment::class);
    }

    function subscribers()
    {
      return $this->belongsToMany(User::class, 'subscriptions');
    }

    function latestComments()
    {
      return $this->comments()->orderBy('created_at', 'DESC');
    }

    function setTitleAttribute($value)
    {
      $this->attributes['title'] = $value;

      $this->attributes['slug'] = Str::slug($value);

    }

    function getUrlAttribute()
    {
      return route('posts.show', [$this->id, $this->slug]);
    }

    function getSafeHtmlContentAttribute()
    {
      return Markdown::convertToHtml(e($this->content));
    }

}
