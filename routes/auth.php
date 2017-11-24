<?php

//Post
Route::get('posts/create', [
  'uses'  => 'CreatePostsController@create',
  'as'    => 'posts.create'
]);

Route::post('posts/create', [
  'uses'  => 'CreatePostsController@store',
  'as'    => 'posts.store'
]);

//comments
Route::post('posts/{post}/comment', [
  'uses'  => 'CreateCommentController@store',
  'as'    => 'comments.store'
]);

Route::post('posts/{comment}/accept', [
  'uses'  => 'CreateCommentController@accept',
  'as'    => 'comments.accept'
]);

//subscribe
Route::post('posts/{post}/subscribe', [
  'uses'  => 'SubscriptionController@subscribe',
  'as'    => 'posts.subscribe'
]);

Route::delete('posts/{post}/subscribe', [
  'uses'  => 'SubscriptionController@unsubscribe',
  'as'    => 'posts.unsubscribe'
]);
