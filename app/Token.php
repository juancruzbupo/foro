<?php

namespace App;

use App\Mail\TokenMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Token extends Model
{
  protected $guarded = [];

  function user()
  {
    return $this->belongsTo(User::class);
  }

  public static function generateFor(User $user)
  {
    $token = new static;

    $token->token = str_random(60);

    $token->user()->associate($user); //method in belongsTo eloquent

    $token->save();

    return $token;

  }

  function sendByEmail()
  {
    Mail::to($this->user)->send(new TokenMail($this));
  }
}
